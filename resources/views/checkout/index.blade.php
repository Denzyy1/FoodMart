{{-- filepath: c:\xampp\foodmart-app\resources\views\checkout\index.blade.php --}}
<x-admin-layout>
    <x-slot name="content">
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">Checkout</li>
                            </ol>
                        </nav>
                        <h2 class="mb-4">Checkout</h2>
                    </div>
                </div>

                <div class="row">
                    <!-- Checkout Form -->
                    <div class="col-lg-7">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-dark text-white">
                                <h5 class="mb-0">Shipping Information</h5>
                            </div>
                            <div class="card-body">
                                <form id="checkoutForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="shipping_name" id="shipping_name" 
                                                   value="{{ auth()->user()->name ?? '' }}" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="shipping_email" id="shipping_email" 
                                                   value="{{ auth()->user()->email ?? '' }}" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Phone Number <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" name="shipping_phone" id="shipping_phone" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Address <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="shipping_address" id="shipping_address" rows="2" required></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">City <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="shipping_city" id="shipping_city" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">ZIP Code <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="shipping_zip" id="shipping_zip" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Order Notes (Optional)</label>
                                        <textarea class="form-control" name="notes" id="notes" rows="2" placeholder="Any special instructions for delivery..."></textarea>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="card shadow-sm">
                            <div class="card-header bg-dark text-white">
                                <h5 class="mb-0">Payment Method</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-check p-3 border rounded bg-light">
                                    <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                    <label class="form-check-label d-flex align-items-center" for="cod">
                                        <span class="me-3">
                                            <svg width="32" height="32" fill="currentColor" class="text-success" viewBox="0 0 16 16">
                                                <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1H1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                                                <path d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V5zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2H3z"/>
                                            </svg>
                                        </span>
                                        <div>
                                            <strong>Cash on Delivery</strong>
                                            <p class="mb-0 text-muted small">Pay when you receive your order</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="col-lg-5">
                        <div class="card shadow-sm sticky-top" style="top: 20px;">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">Order Summary</h5>
                            </div>
                            <div class="card-body">
                                <div id="checkoutItems">
                                    <p class="text-muted text-center">Loading cart...</p>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span id="checkoutSubtotal" class="fw-bold">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tax (10%):</span>
                                    <span id="checkoutTax">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Shipping:</span>
                                    <span id="checkoutShipping">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2 text-muted small">
                                    <span>Free shipping on orders over $50</span>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between mb-4">
                                    <span class="fs-5 fw-bold">Total:</span>
                                    <span id="checkoutTotal" class="fs-4 fw-bold text-success">$0.00</span>
                                </div>

                                <button type="button" id="placeOrderBtn" class="btn btn-success btn-lg w-100" disabled>
                                    <svg width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                    </svg>
                                    Place Order
                                </button>

                                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary w-100 mt-2">
                                    ← Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Loading Overlay -->
        <div id="loadingOverlay" class="position-fixed top-0 start-0 w-100 h-100 d-none" style="background: rgba(0,0,0,0.5); z-index: 9999;">
            <div class="d-flex justify-content-center align-items-center h-100">
                <div class="bg-white p-4 rounded shadow text-center">
                    <div class="spinner-border text-success mb-3" role="status"></div>
                    <p class="mb-0">Processing your order...</p>
                </div>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cart = JSON.parse(localStorage.getItem('foodmart_cart')) || [];
            const checkoutItems = document.getElementById('checkoutItems');
            const placeOrderBtn = document.getElementById('placeOrderBtn');
            const loadingOverlay = document.getElementById('loadingOverlay');

            function calculateTotals() {
                const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                const tax = subtotal * 0.10;
                const shipping = subtotal >= 50 ? 0 : 5.00;
                const total = subtotal + tax + shipping;
                return { subtotal, tax, shipping, total };
            }

            function renderCheckout() {
                if (cart.length === 0) {
                    checkoutItems.innerHTML = '<p class="text-muted text-center">Your cart is empty.</p>';
                    placeOrderBtn.disabled = true;
                    return;
                }

                let html = '';
                cart.forEach(item => {
                    html += `
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                            <img src="${item.image}" alt="${item.name}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                            <div class="ms-3 flex-grow-1">
                                <h6 class="mb-0" style="font-size: 14px;">${item.name}</h6>
                                <small class="text-muted">Qty: ${item.quantity} × $${item.price.toFixed(2)}</small>
                            </div>
                            <span class="fw-bold">$${(item.price * item.quantity).toFixed(2)}</span>
                        </div>
                    `;
                });
                checkoutItems.innerHTML = html;

                const totals = calculateTotals();
                document.getElementById('checkoutSubtotal').textContent = '$' + totals.subtotal.toFixed(2);
                document.getElementById('checkoutTax').textContent = '$' + totals.tax.toFixed(2);
                document.getElementById('checkoutShipping').textContent = totals.shipping > 0 ? '$' + totals.shipping.toFixed(2) : 'FREE';
                document.getElementById('checkoutTotal').textContent = '$' + totals.total.toFixed(2);

                placeOrderBtn.disabled = false;
            }

            renderCheckout();

            // Place Order
            placeOrderBtn.addEventListener('click', async function() {
                const form = document.getElementById('checkoutForm');
                
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                if (cart.length === 0) {
                    alert('Your cart is empty!');
                    return;
                }

                loadingOverlay.classList.remove('d-none');
                placeOrderBtn.disabled = true;

                const formData = {
                    cart: cart,
                    shipping_name: document.getElementById('shipping_name').value,
                    shipping_email: document.getElementById('shipping_email').value,
                    shipping_phone: document.getElementById('shipping_phone').value,
                    shipping_address: document.getElementById('shipping_address').value,
                    shipping_city: document.getElementById('shipping_city').value,
                    shipping_zip: document.getElementById('shipping_zip').value,
                    notes: document.getElementById('notes').value,
                };

                try {
                    const response = await fetch('{{ route("checkout.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(formData),
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Clear cart
                        localStorage.removeItem('foodmart_cart');
                        // Redirect to success page
                        window.location.href = data.redirect;
                    } else {
                        alert(data.message || 'Failed to place order. Please try again.');
                        loadingOverlay.classList.add('d-none');
                        placeOrderBtn.disabled = false;
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                    loadingOverlay.classList.add('d-none');
                    placeOrderBtn.disabled = false;
                }
            });
        });
        </script>
    </x-slot>
</x-admin-layout>