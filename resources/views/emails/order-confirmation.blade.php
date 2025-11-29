<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f4;">
    <table role="presentation" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table role="presentation" style="width: 600px; border-collapse: collapse; background-color: #ffffff; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px;">🛒 Order Confirmed!</h1>
                            <p style="color: #ffffff; margin: 10px 0 0 0; font-size: 16px;">Thank you for shopping with FoodMart</p>
                        </td>
                    </tr>
                    
                    <!-- Order Info -->
                    <tr>
                        <td style="padding: 30px;">
                            <table style="width: 100%; margin-bottom: 20px;">
                                <tr>
                                    <td style="padding: 10px; background-color: #f8f9fa; border-radius: 5px;">
                                        <strong>Order Number:</strong> {{ $order->order_number }}<br>
                                        <strong>Order Date:</strong> {{ $order->created_at->format('F d, Y h:i A') }}<br>
                                        <strong>Payment Method:</strong> Cash on Delivery
                                    </td>
                                </tr>
                            </table>

                            <h3 style="color: #333; border-bottom: 2px solid #28a745; padding-bottom: 10px;">Order Items</h3>
                            
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="background-color: #f8f9fa;">
                                        <th style="padding: 12px; text-align: left; border-bottom: 1px solid #dee2e6;">Product</th>
                                        <th style="padding: 12px; text-align: center; border-bottom: 1px solid #dee2e6;">Qty</th>
                                        <th style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">Price</th>
                                        <th style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">{{ $item->product_name }}</td>
                                        <td style="padding: 12px; text-align: center; border-bottom: 1px solid #dee2e6;">{{ $item->quantity }}</td>
                                        <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">${{ number_format($item->price, 2) }}</td>
                                        <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">${{ number_format($item->total, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" style="padding: 8px; text-align: right;">Subtotal:</td>
                                        <td style="padding: 8px; text-align: right;">${{ number_format($order->subtotal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="padding: 8px; text-align: right;">Tax (10%):</td>
                                        <td style="padding: 8px; text-align: right;">${{ number_format($order->tax, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="padding: 8px; text-align: right;">Shipping:</td>
                                        <td style="padding: 8px; text-align: right;">{{ $order->shipping > 0 ? '$' . number_format($order->shipping, 2) : 'FREE' }}</td>
                                    </tr>
                                    <tr style="background-color: #28a745; color: white;">
                                        <td colspan="3" style="padding: 12px; text-align: right; font-weight: bold;">Total:</td>
                                        <td style="padding: 12px; text-align: right; font-weight: bold; font-size: 18px;">${{ number_format($order->total, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>

                            <h3 style="color: #333; border-bottom: 2px solid #28a745; padding-bottom: 10px; margin-top: 30px;">Shipping Address</h3>
                            <p style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 0;">
                                <strong>{{ $order->shipping_name }}</strong><br>
                                {{ $order->shipping_address }}<br>
                                {{ $order->shipping_city }}, {{ $order->shipping_zip }}<br>
                                Phone: {{ $order->shipping_phone }}<br>
                                Email: {{ $order->shipping_email }}
                            </p>

                            @if($order->notes)
                            <h3 style="color: #333; margin-top: 20px;">Order Notes</h3>
                            <p style="background-color: #fff3cd; padding: 15px; border-radius: 5px; margin: 0;">{{ $order->notes }}</p>
                            @endif

                            <div style="background-color: #d4edda; padding: 15px; border-radius: 5px; margin-top: 30px; text-align: center;">
                                <p style="margin: 0; color: #155724;">
                                    <strong>💵 Cash on Delivery</strong><br>
                                    Please have ${{ number_format($order->total, 2) }} ready when your order arrives.
                                </p>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8f9fa; padding: 20px; text-align: center; border-radius: 0 0 10px 10px;">
                            <p style="color: #28a745; font-size: 16px; font-weight: bold; margin: 0;">Thank you for your order! 🎉</p>
                            <p style="color: #666666; font-size: 14px; margin: 10px 0 0 0;">The FoodMart Team</p>
                            <hr style="border: none; border-top: 1px solid #dee2e6; margin: 20px 0;">
                            <p style="color: #999999; font-size: 12px; margin: 0;">
                                © {{ date('Y') }} FoodMart. All rights reserved.<br>
                                <a href="{{ config('app.url') }}" style="color: #28a745;">{{ config('app.url') }}</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>