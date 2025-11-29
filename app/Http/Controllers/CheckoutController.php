<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Mail\OrderConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'required|integer',
            'cart.*.name' => 'required|string',
            'cart.*.price' => 'required|numeric|min:0',
            'cart.*.quantity' => 'required|integer|min:1',
            'cart.*.image' => 'nullable|string',
            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:100',
            'shipping_zip' => 'required|string|max:20',
            'notes' => 'nullable|string|max:500',
        ]);


        $subtotal = 0;
        foreach ($validated['cart'] as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        $tax = $subtotal * 0.10; 
        $shipping = $subtotal >= 50 ? 0 : 5.00; 
        $total = $subtotal + $tax + $shipping;

       
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => Order::generateOrderNumber(),
            'status' => 'pending',
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'total' => $total,
        
            'tax_amount' => $tax,
            'shipping_amount' => $shipping,
            'discount_amount' => 0,
            'total_amount' => $total,
            'coupon_code' => null,
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'shipping_name' => $validated['shipping_name'],
            'shipping_email' => $validated['shipping_email'],
            'shipping_phone' => $validated['shipping_phone'],
            'shipping_address' => $validated['shipping_address'],
            'shipping_city' => $validated['shipping_city'],
            'shipping_zip' => $validated['shipping_zip'],
            'shipping_state' => '',
            'shipping_zipcode' => $validated['shipping_zip'],
            'shipping_country' => 'Egypt',
            'notes' => $validated['notes'] ?? null,
        ]);

      
        foreach ($validated['cart'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'product_image' => $item['image'] ?? null,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['price'] * $item['quantity'],
            ]);

         
            $product = Product::find($item['id']);
            if ($product) {
                $product->decrement('stock_quantity', $item['quantity']);
            }
        }

        $order->load('items');

        $emailSent = false;
        try {
            Mail::to($validated['shipping_email'])->send(new OrderConfirmationMail($order));
            $emailSent = true;
            Log::info('Order confirmation email sent to: ' . $validated['shipping_email']);
        } catch (\Exception $e) {
            Log::error('Failed to send order confirmation email: ' . $e->getMessage());
            Log::error('Email error trace: ' . $e->getTraceAsString());
        }

        return response()->json([
            'success' => true,
            'message' => $emailSent ? 'Order placed successfully! Confirmation email sent.' : 'Order placed successfully! (Email could not be sent)',
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'total' => $order->total,
            ],
            'email_sent' => $emailSent,
            'redirect' => route('checkout.success', $order->order_number),
        ]);
    }

    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->with('items')->firstOrFail();
        return view('checkout.success', compact('order'));
    }
}
