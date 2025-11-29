<x-admin-layout>
    <x-slot name="content">
        <div id="cartPanel" class="position-fixed top-0 end-0 bg-white shadow-lg" 
             style="width: 380px; max-width: 90vw; height: 100vh; transform: translateX(100%); transition: transform 0.3s ease; z-index: 1055;">
            
            <div class="d-flex flex-column h-100">
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom bg-dark text-white">
                    <h5 class="mb-0">Shopping Cart</h5>
                    <button type="button" class="btn-close btn-close-white" id="cartCloseBtn"></button>
                </div>
                <div id="cartItemsContainer" class="flex-grow-1 overflow-auto p-3">
                    <p class="text-muted text-center my-5">Your cart is empty.</p>
                </div>
                <div class="border-top p-3 bg-light">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span id="cartSubtotal" class="fw-bold">$0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Total:</span>
                        <span id="cartTotalPrice" class="fw-bold fs-5 text-success">$0.00</span>
                    </div>
                    <button id="checkoutBtn" class="btn btn-success w-100 mb-2" disabled>Proceed to Checkout</button>
                    <button id="clearCartBtn" class="btn btn-outline-danger w-100">Clear Cart</button>
                </div>
            </div>
        </div>
        <div id="cartOverlay" class="position-fixed top-0 start-0 w-100 h-100 bg-dark" 
             style="opacity: 0; visibility: hidden; transition: opacity 0.3s ease; z-index: 1050;"></div>

        <section class="py-3 bg-light">
            <div class="container-fluid">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Categories</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                    </ol>
                </nav>
            </div>
        </section>

       
        <section class="py-4">
            <div class="container-fluid">
                <div class="d-flex align-items-center mb-4">
                    @if($category->image)
                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="me-3" style="width: 60px; height: 60px; object-fit: contain;">
                    @endif
                    <div>
                        <h1 class="mb-1">{{ $category->name }}</h1>
                        @if($category->description)
                        <p class="text-muted mb-0">{{ $category->description }}</p>
                        @endif
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2 mb-4">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill">All Categories</a>
                    @foreach($categories as $cat)
                    <a href="{{ route('category.show', $cat->slug) }}" 
                       class="btn btn-sm rounded-pill {{ $cat->id === $category->id ? 'btn-success' : 'btn-outline-success' }}">
                        {{ $cat->name }}
                    </a>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="py-4">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <p class="text-muted mb-0">{{ $products->total() }} products found</p>
                </div>

                @if($products->count() > 0)
                <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                    @foreach($products as $product)
                    <div class="col">
                        <div class="product-item" 
                             data-product-id="{{ $product->id }}" 
                             data-product-name="{{ $product->name }}" 
                             data-product-price="{{ $product->price }}" 
                             data-product-image="{{ $product->image ? asset('storage/' . $product->image) : asset('admin/images/thumb-bananas.png') }}">
                            @if($product->sale_price)
                            <span class="badge bg-success position-absolute m-3">Sale</span>
                            @endif
                            <a href="#" class="btn-wishlist"><svg width="24" height="24"><use xlink:href="#heart"></use></svg></a>
                            <figure>
                                <a href="#" title="{{ $product->name }}">
                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('admin/images/thumb-bananas.png') }}" class="tab-image" alt="{{ $product->name }}">
                                </a>
                            </figure>
                            <h3>{{ $product->name }}</h3>
                            <span class="qty">{{ $product->stock_quantity }} in stock</span>
                            <span class="rating"><svg width="24" height="24" class="text-primary"><use xlink:href="#star-solid"></use></svg> {{ number_format($product->rating ?? 4.5, 1) }}</span>
                            <span class="price">${{ number_format($product->price, 2) }}</span>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="input-group product-qty">
                                    <button type="button" class="quantity-left-minus btn btn-danger btn-number">
                                        <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                    </button>
                                    <input type="text" class="form-control input-number product-quantity" value="1" min="1" max="99">
                                    <button type="button" class="quantity-right-plus btn btn-success btn-number">
                                        <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                    </button>
                                </div>
                                <a href="#" class="nav-link add-to-cart-btn">Add to Cart <iconify-icon icon="uil:shopping-cart"></iconify-icon></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <img src="{{ asset('admin/images/icon-vegetables-broccoli.png') }}" alt="No products" style="width: 100px; opacity: 0.5;">
                    <h4 class="text-muted mt-3">No products in this category</h4>
                    <p class="text-muted">Check back later or browse other categories.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-success">Browse All Products</a>
                </div>
                @endif
            </div>
        </section>
    </x-slot>
</x-admin-layout>