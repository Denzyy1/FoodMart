<x-admin-layout>
    <x-slot name="content">
        <section class="py-5">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2>Search Results</h2>
                        @if($query)
                            <p class="text-muted mb-0">Results for "<strong>{{ $query }}</strong>" ({{ $products->total() }} found)</p>
                        @endif
                    </div>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">← Back to Dashboard</a>
                </div>

                @if($products->count() > 0)
                <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                    @foreach($products as $product)
                    <div class="col mb-4">
                        <div class="product-item" 
                             data-product-id="{{ $product->id }}" 
                             data-product-name="{{ $product->name }}" 
                             data-product-price="{{ $product->price }}" 
                             data-product-image="{{ $product->image ? asset('storage/' . $product->image) : asset('admin/images/thumb-bananas.png') }}">
                            <figure>
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('admin/images/thumb-bananas.png') }}" class="tab-image" alt="{{ $product->name }}">
                            </figure>
                            <h3>{{ $product->name }}</h3>
                            <span class="qty">{{ $product->stock_quantity }} in stock</span>
                            <span class="price">${{ number_format($product->price, 2) }}</span>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="input-group product-qty">
                                    <button type="button" class="quantity-left-minus btn btn-danger btn-number">-</button>
                                    <input type="text" class="form-control input-number product-quantity" value="1">
                                    <button type="button" class="quantity-right-plus btn btn-success btn-number">+</button>
                                </div>
                                <a href="#" class="nav-link add-to-cart-btn">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->appends(['q' => $query])->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <h4 class="text-muted">No products found</h4>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Browse All Products</a>
                </div>
                @endif
            </div>
        </section>
    </x-slot>
</x-admin-layout>