<!DOCTYPE html>
<html lang="en">
<head>
    <title>FoodMart - Online Grocery Store</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    @if(file_exists(public_path('admin/css/style.css')))
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/style.css') }}">
    @endif
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
      <style>
        * { font-family: 'Poppins', sans-serif; }
        body { font-weight: 400; color: #333; }
        h1, h2, h3, h4, h5, h6 { font-weight: 600; }
        .btn { font-weight: 500; }
    </style>
</head>
<body>

    {{-- SVG Icons --}}
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
            <circle cx="12" cy="7" r="4"></circle>
        </symbol>
        <symbol id="heart" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
        </symbol>
        <symbol id="cart" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
        </symbol>
        <symbol id="search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </symbol>
        <symbol id="arrow-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
        </symbol>
        <symbol id="star-solid" viewBox="0 0 24 24" fill="currentColor">
            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
        </symbol>
        <symbol id="minus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="5" y1="12" x2="19" y2="12"></line>
        </symbol>
        <symbol id="plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
        </symbol>
    </svg>

     @include('layouts.partials.navbar')

    <main>
        {{ $content }}
    </main>

    @include('layouts.partials.footer')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Main Banner Swiper
        if (document.querySelector('.main-swiper')) {
            new Swiper('.main-swiper', {
                loop: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                autoplay: {
                    delay: 5000,
                },
            });
        }

        // Category Carousel
        if (document.querySelector('.category-carousel')) {
            new Swiper('.category-carousel', {
                slidesPerView: 2,
                spaceBetween: 20,
                navigation: {
                    nextEl: '.category-carousel-next',
                    prevEl: '.category-carousel-prev',
                },
                breakpoints: {
                    480: { slidesPerView: 3 },
                    768: { slidesPerView: 4 },
                    992: { slidesPerView: 5 },
                    1200: { slidesPerView: 6 },
                },
            });
        }

        // Brand Carousel
        if (document.querySelector('.brand-carousel')) {
            new Swiper('.brand-carousel', {
                slidesPerView: 1,
                spaceBetween: 20,
                navigation: {
                    nextEl: '.brand-carousel-next',
                    prevEl: '.brand-carousel-prev',
                },
                breakpoints: {
                    768: { slidesPerView: 2 },
                    992: { slidesPerView: 3 },
                    1200: { slidesPerView: 4 },
                },
            });
        }
    });
    </script>

    @if(file_exists(public_path('admin/js/script.js')))
    <script src="{{ asset('admin/js/script.js') }}"></script>
    @endif
    @if(file_exists(public_path('admin/js/search.js')))
    <script src="{{ asset('admin/js/search.js') }}"></script>
    @endif
    @if(file_exists(public_path('admin/js/cart.js')))
    <script src="{{ asset('admin/js/cart.js') }}"></script>
    @endif

</body>
</html>