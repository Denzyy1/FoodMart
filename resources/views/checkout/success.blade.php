{{-- filepath: c:\xampp\foodmart-app\resources\views\checkout\success.blade.php --}}
<x-admin-layout>
    <x-slot name="content">
        <section class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <!-- Success Message -->
                        <div class="text-center mb-5">
                            <div class="mb-4">
                                <svg width="80" height="80" fill="currentColor" class="text-success" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                </svg>
                            </div>
                            <h1 class="text-success">Order Placed Successfully!</h1>
                            <p class="lead text-muted">Thank you for your order. A confirmation email has been sent to {{ $order->shipping_email }}</p>
                        </div>

                        <!-- Order Details Card -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Order Details</h5>
                                <span class="badge bg-warning text-dark">{{ ucfirst($order->status) }}</span>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <strong>Order Number:</strong><br>
                                        <span class="text-primary">{{ $order->order_number }}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <strong>Order Date:</strong><br>
                                        {{ $order->created_at->format('F d, Y h:i A') }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <strong>Payment Method:</strong><br>
                                        Cash on Delivery
                                    </div>
                                    <div class="col-sm-6">
                                        <strong>Payment Status:</strong><br>
                                        <span class="badge bg-warning text-dark">{{ ucfirst($order->payment_status) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">Order Items</h5>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Product</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-end">Price</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->items as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($item->product_image)
                                                    <img src="{{ $item->product_image }}" alt="{{ $item->product_name }}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                    @endif
                                                    {{ $item->product_name }}
                                                </div>
                                            </td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">${{ number_format($item->price, 2) }}</td>
                                            <td class="text-end">${{ number_format($item->total, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <td colspan="3" class="text-end">Subtotal:</td>
                                            <td class="text-end">${{ number_format($order->subtotal, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end">Tax (10%):</td>
                                            <td class="text-end">${{ number_format($order->tax, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end">Shipping:</td>
                                            <td class="text-end">{{ $order->shipping > 0 ? '$' . number_format($order->shipping, 2) : 'FREE' }}</td>
                                        </tr>
                                        <tr class="table-success">
                                            <td colspan="3" class="text-end fw-bold fs-5">Total:</td>
                                            <td class="text-end fw-bold fs-5">${{ number_format($order->total, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Shipping Address</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-1"><strong>{{ $order->shipping_name }}</strong></p>
                                <p class="mb-1">{{ $order->shipping_address }}</p>
                                <p class="mb-1">{{ $order->shipping_city }}, {{ $order->shipping_zip }}</p>
                                <p class="mb-1">Phone: {{ $order->shipping_phone }}</p>
                                <p class="mb-0">Email: {{ $order->shipping_email }}</p>
                            </div>
                        </div>

                        @if($order->notes)
                        <div class="card shadow-sm mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Order Notes</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $order->notes }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- COD Notice -->
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <svg width="24" height="24" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                                <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1H1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                                <path d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V5zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2H3z"/>
                            </svg>
                            <div>
                                <strong>Cash on Delivery:</strong> Please have <strong>${{ number_format($order->total, 2) }}</strong> ready when your order arrives.
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="text-center">
                            <a href="{{ route('dashboard') }}" class="btn btn-success btn-lg">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </x-slot>
</x-admin-layout>