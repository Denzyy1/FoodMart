<x-admin-layout>
    <x-slot name="content">
      
      {{-- Cart Side Panel --}}
        <div id="cartPanel" class="position-fixed top-0 end-0 bg-white shadow-lg" 
             style="width: 380px; max-width: 90vw; height: 100vh; transform: translateX(100%); transition: transform 0.3s ease; z-index: 1055;">
            <div class="d-flex flex-column h-100">
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom bg-dark text-white">
                    <h5 class="mb-0"><svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16" class="me-2">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg> Shopping Cart</h5>
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
                    <button id="checkoutBtn" class="btn btn-success w-100 mb-2" disabled>
                        Proceed to Checkout
                    </button>
                    <button id="clearCartBtn" class="btn btn-outline-danger w-100">
                        Clear Cart
                    </button>
                </div>
            </div>
        </div>

        {{-- Cart Overlay --}}
        <div id="cartOverlay" class="position-fixed top-0 start-0 w-100 h-100 bg-dark" 
             style="opacity: 0; visibility: hidden; transition: opacity 0.3s ease; z-index: 1050;"></div>

    <section class="py-5 overflow-hidden">
          <div class="container-fluid">
            @auth
              @if(Auth::user()->hasAnyRole(['admin', 'superadmin']))
              <div class="row mt-5">
                <div class="col-md-12 text-center">
                  <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-5 py-3 shadow me-2">
                    <svg width="24" height="24" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                      <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                    Manage Products
                  </a>
                  @if(Auth::user()->hasRole('superadmin'))
                  <a href="{{ route('users.index') }}" class="btn btn-danger btn-lg px-5 py-3 shadow">
                    <svg width="24" height="24" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                      <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                    </svg>
                    Manage Users
                  </a>
                  @endif
                </div>
              </div>
              @endif
            @endauth
          </div>
        </section>

        
        <section class="py-3" style="background-image: url('{{ asset('admin/images/background-pattern.jpg') }}');background-repeat: no-repeat;background-size: cover;">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">

                <div class="banner-blocks">
                
                  <div class="banner-ad large bg-info block-1">

                    <div class="swiper main-swiper">
                      <div class="swiper-wrapper">
                        
                        <div class="swiper-slide">
                          <div class="row banner-content p-5">
                            <div class="content-wrapper col-md-7">
                              <div class="categories my-3">100% natural</div>
                              <h3 class="display-4">Fresh Smoothie & Summer Juice</h3>
                              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Dignissim massa diam elementum.</p>
                              <a href="#" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1 px-4 py-3 mt-3">Shop Now</a>
                            </div>
                            <div class="img-wrapper col-md-5">
                              <img src="{{ asset('admin/images/product-thumb-1.png') }}" class="img-fluid">
                            </div>
                          </div>
                        </div>
                        
                        <div class="swiper-slide">
                          <div class="row banner-content p-5">
                            <div class="content-wrapper col-md-7">
                              <div class="categories mb-3 pb-3">100% natural</div>
                              <h3 class="banner-title">Fresh Smoothie & Summer Juice</h3>
                              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Dignissim massa diam elementum.</p>
                              <a href="#" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">Shop Collection</a>
                            </div>
                            <div class="img-wrapper col-md-5">
                              <img src="{{ asset('admin/images/product-thumb-1.png') }}" class="img-fluid">
                            </div>
                          </div>
                        </div>
                        
                        <div class="swiper-slide">
                          <div class="row banner-content p-5">
                            <div class="content-wrapper col-md-7">
                              <div class="categories mb-3 pb-3">100% natural</div>
                              <h3 class="banner-title">Heinz Tomato Ketchup</h3>
                              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Dignissim massa diam elementum.</p>
                              <a href="#" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">Shop Collection</a>
                            </div>
                            <div class="img-wrapper col-md-5">
                              <img src="{{ asset('admin/images/product-thumb-2.png') }}" class="img-fluid">
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      <div class="swiper-pagination"></div>

                    </div>
                  </div>
                  
                  <div class="banner-ad bg-success-subtle block-2" style="background:url('{{ asset('admin/images/ad-image-1.png') }}') no-repeat;background-position: right bottom">
                    <div class="row banner-content p-5">

                      <div class="content-wrapper col-md-7">
                        <div class="categories sale mb-3 pb-3">20% off</div>
                        <h3 class="banner-title">Fruits & Vegetables</h3>
                        <a href="#" class="d-flex align-items-center nav-link">Shop Collection <svg width="24" height="24"><use xlink:href="#arrow-right"></use></svg></a>
                      </div>

                    </div>
                  </div>

                  <div class="banner-ad bg-danger block-3" style="background:url('{{ asset('admin/images/ad-image-2.png') }}') no-repeat;background-position: right bottom">
                    <div class="row banner-content p-5">

                      <div class="content-wrapper col-md-7">
                        <div class="categories sale mb-3 pb-3">15% off</div>
                        <h3 class="item-title">Baked Products</h3>
                        <a href="#" class="d-flex align-items-center nav-link">Shop Collection <svg width="24" height="24"><use xlink:href="#arrow-right"></use></svg></a>
                      </div>

                    </div>
                  </div>

                </div>
                
                  
              </div>
            </div>
          </div>
        </section>


        <section class="py-5 overflow-hidden">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">

                <div class="section-header d-flex flex-wrap justify-content-between mb-5">
                  <h2 class="section-title">Shop by Category</h2>

                  <div class="d-flex align-items-center">
                    <a href="#" class="btn-link text-decoration-none">View All Categories →</a>
                    <div class="swiper-buttons">
                      <button class="swiper-prev category-carousel-prev btn btn-yellow">❮</button>
                      <button class="swiper-next category-carousel-next btn btn-yellow">❯</button>
                    </div>
                  </div>
                </div>
                
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">

                @if($categories->count() > 0)
                <div class="category-carousel swiper">
                  <div class="swiper-wrapper">
                    @foreach($categories as $category)
                    <div class="swiper-slide">
                      <a href="{{ route('category.show', $category->slug) }}" class="nav-link category-item text-center d-block p-3">
                        <img src="{{ $category->image ? asset($category->image) : asset('admin/images/icon-vegetables-broccoli.png') }}" alt="{{ $category->name }}" style="width: 80px; height: 80px; object-fit: contain;">
                        <h3 class="category-title mt-2">{{ $category->name }}</h3>
                        <span class="badge bg-success rounded-pill">{{ $category->products_count }} items</span>
                      </a>
                    </div>
                    @endforeach
                  </div>
                </div>
                @else
              
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3">
                  <div class="col">
                    <a href="#" class="nav-link category-item text-center d-block p-3 border rounded">
                      <img src="{{ asset('admin/images/icon-vegetables-broccoli.png') }}" alt="Fruits & Veges" style="width: 60px; height: 60px;">
                      <h6 class="category-title mt-2 mb-0">Fruits & Veges</h6>
                    </a>
                  </div>
                  <div class="col">
                    <a href="#" class="nav-link category-item text-center d-block p-3 border rounded">
                      <img src="{{ asset('admin/images/icon-bread-baguette.png') }}" alt="Breads & Sweets" style="width: 60px; height: 60px;">
                      <h6 class="category-title mt-2 mb-0">Breads & Sweets</h6>
                    </a>
                  </div>
                  <div class="col">
                    <a href="#" class="nav-link category-item text-center d-block p-3 border rounded">
                      <img src="{{ asset('admin/images/icon-soft-drinks-bottle.png') }}" alt="Beverages" style="width: 60px; height: 60px;">
                      <h6 class="category-title mt-2 mb-0">Beverages</h6>
                    </a>
                  </div>
                  <div class="col">
                    <a href="#" class="nav-link category-item text-center d-block p-3 border rounded">
                      <img src="{{ asset('admin/images/icon-wine-glass-bottle.png') }}" alt="Wine & Spirits" style="width: 60px; height: 60px;">
                      <h6 class="category-title mt-2 mb-0">Wine & Spirits</h6>
                    </a>
                  </div>
                  <div class="col">
                    <a href="#" class="nav-link category-item text-center d-block p-3 border rounded">
                      <img src="{{ asset('admin/images/icon-animal-products-drumsticks.png') }}" alt="Meat & Poultry" style="width: 60px; height: 60px;">
                      <h6 class="category-title mt-2 mb-0">Meat & Poultry</h6>
                    </a>
                  </div>
                  <div class="col">
                    <a href="#" class="nav-link category-item text-center d-block p-3 border rounded">
                      <img src="{{ asset('admin/images/icon-bread-herb-flour.png') }}" alt="Dairy" style="width: 60px; height: 60px;">
                      <h6 class="category-title mt-2 mb-0">Dairy</h6>
                    </a>
                  </div>
                </div>
                @endif

              </div>
            </div>
          </div>
        </section>


        <section class="py-5">
          <div class="container-fluid">
            
            <div class="bootstrap-tabs product-tabs">
              <div class="tabs-header d-flex justify-content-between border-bottom my-5">
                <h3>Trending Products</h3>
                <nav>
                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a href="#" class="nav-link text-uppercase fs-6 active" id="nav-all-tab" data-bs-toggle="tab" data-bs-target="#nav-all">All</a>
                    <a href="#" class="nav-link text-uppercase fs-6" id="nav-fruits-tab" data-bs-toggle="tab" data-bs-target="#nav-fruits">Fruits & Veges</a>
                    <a href="#" class="nav-link text-uppercase fs-6" id="nav-dairy-tab" data-bs-toggle="tab" data-bs-target="#nav-dairy">Dairy</a>
                  </div>
                </nav>
              </div>
              <div class="tab-content" id="nav-tabContent">
                {{-- All Products Tab --}}
                <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
                  <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                    @forelse($products as $product)
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
                              <span class="input-group-btn">
                                  <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
                                    <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                  </button>
                              </span>
                              <input type="text" name="quantity" class="form-control input-number product-quantity" value="1" min="1" max="99">
                              <span class="input-group-btn">
                                  <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
                                      <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                  </button>
                              </span>
                          </div>
                          <a href="#" class="nav-link add-to-cart-btn">Add to Cart <iconify-icon icon="uil:shopping-cart"></iconify-icon></a>
                        </div>
                      </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                      <p class="text-muted">No products available yet.</p>
                      @auth
                      <a href="{{ route('products.create') }}" class="btn btn-primary">Add Your First Product</a>
                      @endauth
                    </div>
                    @endforelse
                  </div>
                </div>

                {{-- Fruits & Vegetables Tab --}}
                <div class="tab-pane fade" id="nav-fruits" role="tabpanel" aria-labelledby="nav-fruits-tab">
                  <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                    @php $fruitsVeges = $products->whereIn('type', ['fruits', 'vegetables']); @endphp
                    @forelse($fruitsVeges as $product)
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
                              <span class="input-group-btn">
                                  <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
                                    <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                  </button>
                              </span>
                              <input type="text" name="quantity" class="form-control input-number product-quantity" value="1" min="1" max="99">
                              <span class="input-group-btn">
                                  <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
                                      <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                  </button>
                              </span>
                          </div>
                          <a href="#" class="nav-link add-to-cart-btn">Add to Cart <iconify-icon icon="uil:shopping-cart"></iconify-icon></a>
                        </div>
                      </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                      <p class="text-muted">No fruits or vegetables available.</p>
                    </div>
                    @endforelse
                  </div>
                </div>

                {{-- Dairy Tab --}}
                <div class="tab-pane fade" id="nav-dairy" role="tabpanel" aria-labelledby="nav-dairy-tab">
                  <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                    @php $dairyProducts = $products->where('type', 'dairy'); @endphp
                    @forelse($dairyProducts as $product)
                    <div class="col">
                      <div class="product-item" 
                           data-product-id="{{ $product->id }}" 
                           data-product-name="{{ $product->name }}" 
                           data-product-price="{{ $product->price }}" 
                           data-product-image="{{ $product->image ? asset('storage/' . $product->image) : asset('admin/images/thumb-milk.png') }}">
                        @if($product->sale_price)
                        <span class="badge bg-success position-absolute m-3">Sale</span>
                        @endif
                        <a href="#" class="btn-wishlist"><svg width="24" height="24"><use xlink:href="#heart"></use></svg></a>
                        <figure>
                          <a href="#" title="{{ $product->name }}">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('admin/images/thumb-milk.png') }}" class="tab-image" alt="{{ $product->name }}">
                          </a>
                        </figure>
                        <h3>{{ $product->name }}</h3>
                        <span class="qty">{{ $product->stock_quantity }} in stock</span>
                        <span class="rating"><svg width="24" height="24" class="text-primary"><use xlink:href="#star-solid"></use></svg> {{ number_format($product->rating ?? 4.5, 1) }}</span>
                        <span class="price">${{ number_format($product->price, 2) }}</span>
                        <div class="d-flex align-items-center justify-content-between">
                          <div class="input-group product-qty">
                              <span class="input-group-btn">
                                  <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
                                    <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                  </button>
                              </span>
                              <input type="text" name="quantity" class="form-control input-number product-quantity" value="1" min="1" max="99">
                              <span class="input-group-btn">
                                  <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
                                      <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                  </button>
                              </span>
                          </div>
                          <a href="#" class="nav-link add-to-cart-btn">Add to Cart <iconify-icon icon="uil:shopping-cart"></iconify-icon></a>
                        </div>
                      </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                      <p class="text-muted">No dairy products available.</p>
                    </div>
                    @endforelse
                  </div>
                </div>

              </div>
            </div>
          </div>
        </section>




    </x-slot>
</x-admin-layout>