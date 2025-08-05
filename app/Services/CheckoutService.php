<?php

namespace App\Services;

use App\Events\PaymentSucceeded;
use App\Models\{CartItem, Order, OrderItem, Payment, Product};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Events\OrderPlaced;
use Illuminate\Support\Facades\Log;

class CheckoutService
{
    

 public function checkout($address, $paymentMethod)
{
        $user = Auth::user();
        $cartItem = CartItem::with('product.seller')
            ->whereHas('cart', fn($q) => $q->where('user_id', $user->id))
            ->get();

        if ($cartItem->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Your cart is empty']);
        }

        return DB::transaction(function() use ($cartItem, $user,$address,$paymentMethod) {
            $orders = [];

            // Group by Vendor
            $sellerGroups = $cartItem->groupBy(fn($item) => $item->product->seller_id);
            Log::info(json_encode($sellerGroups));

            foreach ($sellerGroups as $sellerId => $items) {
                Log::info("seller id=".$sellerId);
                $total = 0;
                foreach ($items as $item) {
                    if ($item->quantity > $item->product->in_stock) {
                       return response()->json(['status' => false, 'message' => "Not enough stock for ".$item->product->name]);
                    }
                    $total += $item->product->price * $item->quantity;
                }

                $order = Order::create([
                    'user_id' => $user->id,
                    'total_amount' => $total,
                    'status' => 'complete',
                    'shipping_address' => $address,
                    'seller_id' => $sellerId,
                    'payment_status' => $paymentMethod === 'cod' ? 'paid' : 'unpaid',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);


                // Create OrderItems & Deduct Stock
                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->product->price,
                    ]);

                    Product::where('id', $item->product_id)
                        ->decrement('in_stock', $item->quantity);
                }

                // Create Payment
               $payment =  Payment::create([
                    'order_id' => $order->id,
                    'amount' => $total,
                    'payment_method' => $paymentMethod === 'cod' ? 'cash on delivery' : 'online',
                    'status' => $paymentMethod === 'cod' ? 'paid' : 'uppaid',
                    'transaction_no' => mt_rand(9,99999999),
                ]);
                
                event(new OrderPlaced($order));
                event(new PaymentSucceeded($payment));
            }

            // Clear Cart
            $cartItem->each->delete();

          
            return response()->json(['status' => true, 'message' => 'Order placed successfully']);
        });
        

    }

}
