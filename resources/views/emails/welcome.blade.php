{{-- filepath: c:\xampp\foodmart-app\resources\views\emails\welcome.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to FoodMart</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f4;">
    <table role="presentation" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table role="presentation" style="width: 600px; border-collapse: collapse; background-color: #ffffff; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); padding: 40px; text-align: center; border-radius: 10px 10px 0 0;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 32px;">🛒 FoodMart</h1>
                            <p style="color: #ffffff; margin: 10px 0 0 0; font-size: 16px;">Your Online Grocery Store</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px;">
                            <h2 style="color: #28a745; margin: 0 0 20px 0;">Welcome, {{ $user->name }}! 🎉</h2>
                            
                            <p style="color: #333333; font-size: 16px; line-height: 1.6; margin: 0 0 20px 0;">
                                Thank you for joining FoodMart! We're thrilled to have you as part of our community.
                            </p>
                            
                            <p style="color: #333333; font-size: 16px; line-height: 1.6; margin: 0 0 20px 0;">
                                Here's what you can do now:
                            </p>
                            
                            <table role="presentation" style="width: 100%; margin: 20px 0;">
                                <tr>
                                    <td style="padding: 10px 0;">✅ Browse fresh fruits and vegetables</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0;">✅ Shop dairy products and beverages</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0;">✅ Find bakery items and snacks</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0;">✅ Enjoy exclusive deals and discounts</td>
                                </tr>
                            </table>
                            
                            <!-- CTA Button -->
                            <table role="presentation" style="width: 100%; margin: 30px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ config('app.url') }}/dashboard" style="display: inline-block; background-color: #28a745; color: #ffffff; text-decoration: none; padding: 15px 40px; border-radius: 5px; font-size: 16px; font-weight: bold;">
                                            Start Shopping Now →
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="color: #666666; font-size: 14px; line-height: 1.6; margin: 20px 0 0 0;">
                                If you have any questions, feel free to reply to this email or contact our support team.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8f9fa; padding: 30px; text-align: center; border-radius: 0 0 10px 10px;">
                            <p style="color: #28a745; font-size: 16px; font-weight: bold; margin: 0;">Happy Shopping! 🛍️</p>
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