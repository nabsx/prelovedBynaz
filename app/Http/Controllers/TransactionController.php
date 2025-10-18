<?php
// app/Http/Controllers/TransactionController.php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class TransactionController extends Controller
{
    public function __construct()
    {
        // Midtrans Configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function checkout()
    {
        $carts = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang kosong');
        }

        // Validasi stok
        foreach ($carts as $cart) {
            if ($cart->quantity > $cart->product->stock) {
                return redirect()->route('cart.index')
                    ->with('error', "Stok {$cart->product->name} tidak mencukupi");
            }
        }

        $total = $carts->sum(function ($cart) {
            return $cart->quantity * $cart->product->price;
        });

        return view('checkout.index', compact('carts', 'total'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $carts = Cart::with('product')
                ->where('user_id', auth()->id())
                ->get();

            if ($carts->isEmpty()) {
                throw new \Exception('Keranjang kosong');
            }

            $totalAmount = $carts->sum(function ($cart) {
                return $cart->quantity * $cart->product->price;
            });

            // Create transaction
            $orderId = 'ORDER-' . time() . '-' . auth()->id();
            
            $transaction = Transaction::create([
                'order_id' => $orderId,
                'user_id' => auth()->id(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'customer_details' => json_encode([
                    'phone' => $request->phone,
                    'address' => $request->address,
                ]),
            ]);

            // Create transaction items
            foreach ($carts as $cart) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price,
                ]);
            }

            // Midtrans Snap Token
            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $totalAmount,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                    'phone' => $request->phone,
                ],
                'item_details' => $carts->map(function ($cart) {
                    return [
                        'id' => $cart->product->id,
                        'price' => (int) $cart->product->price,
                        'quantity' => $cart->quantity,
                        'name' => $cart->product->name,
                    ];
                })->toArray(),
            ];

            $snapToken = Snap::getSnapToken($params);
            $transaction->update(['snap_token' => $snapToken]);

            // Clear cart
            Cart::where('user_id', auth()->id())->delete();

            DB::commit();

            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $orderId,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function notification(Request $request)
    {
        try {
            $notification = new Notification();

            $transaction = Transaction::where('order_id', $notification->order_id)->firstOrFail();

            if ($notification->transaction_status == 'capture' || 
                $notification->transaction_status == 'settlement') {
                
                $transaction->update([
                    'status' => 'success',
                    'payment_type' => $notification->payment_type,
                    'paid_at' => now(),
                ]);

                // Kurangi stok
                foreach ($transaction->items as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->decrement('stock', $item->quantity);
                    }
                }

            } elseif ($notification->transaction_status == 'pending') {
                $transaction->update(['status' => 'pending']);
            } elseif ($notification->transaction_status == 'deny' || 
                      $notification->transaction_status == 'expire' || 
                      $notification->transaction_status == 'cancel') {
                $transaction->update(['status' => 'failed']);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function success(Request $request)
    {
        $transaction = Transaction::where('order_id', $request->order_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('checkout.success', compact('transaction'));
    }

    // User: Transaction history
    public function history()
    {
        $transactions = Transaction::with('items.product')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('transactions.history', compact('transactions'));
    }

    // Admin: All transactions
    public function adminIndex()
    {
        $transactions = Transaction::with('user', 'items.product')
            ->latest()
            ->paginate(15);

        return view('admin.transactions.index', compact('transactions'));
    }

    public function adminShow(Transaction $transaction)
    {
        $transaction->load('user', 'items.product');
        return view('admin.transactions.show', compact('transaction'));
    }
}