<header>
  <div class="container-fluid">
    <div class="row py-3 border-bottom align-items-center">

      <div class="col-3 col-lg-2 text-center text-sm-start">
        <div class="main-logo">
          <a href="{{ route('dashboard') }}">
            <img src="{{ asset('admin/images/logo.png') }}" alt="logo" class="img-fluid" style="max-height: 50px;">
          </a>
        </div>
      </div>

      <div class="col-5 col-lg-5 d-none d-md-block">
        <div class="search-bar row bg-light p-2 rounded-4 position-relative">
          <div class="col-11">
            <form id="searchForm" action="/search" method="GET">
              <input id="searchInput" name="q" type="text" class="form-control border-0 bg-transparent" placeholder="Search for products..." autocomplete="off" value="{{ request('q') }}" />
            </form>
          </div>
          <div class="col-1 d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z"/></svg>
          </div>
          <div id="searchResults" class="position-absolute w-100 bg-white shadow-lg rounded-bottom start-0" style="display: none; z-index: 1070; max-height: 400px; overflow-y: auto; top: 100%;"></div>
        </div>
      </div>
      
      <div class="col-9 col-md-4 col-lg-5 d-flex justify-content-end align-items-center">
        @auth
        <div class="d-flex align-items-center gap-2">
          <span class="fw-medium text-success d-none d-sm-inline">
            Hello, {{ Auth::user()->name }}
            @if(Auth::user()->hasRole('superadmin'))
              <span class="badge bg-danger ms-1">Super Admin</span>
            @elseif(Auth::user()->hasRole('admin'))
              <span class="badge bg-warning text-dark ms-1">Admin</span>
            @endif
          </span>
          
          {{-- Admin Dropdown --}}
          @if(Auth::user()->hasAnyRole(['admin', 'superadmin']))
          <div class="dropdown">
            <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
              Admin
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="{{ route('products.index') }}">Manage Products</a></li>
              @if(Auth::user()->hasRole('superadmin'))
              <li><a class="dropdown-item" href="{{ route('users.index') }}">Manage Users</a></li>
              @endif
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
            </ul>
          </div>
          @endif

          <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm" title="Sign Out">
              <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
              </svg>
              <span class="d-none d-lg-inline ms-1">Sign Out</span>
            </button>
          </form>
          
          {{-- Cart Button --}}
          <button id="cartToggleBtn" type="button" class="btn btn-dark btn-sm position-relative ms-2">
            <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
              <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </svg>
            <span id="cartCountBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark" style="font-size: 10px;">0</span>
          </button>
        </div>
        @else
        {{-- ...existing guest code... --}}
        <div class="d-flex align-items-center gap-2">
          <a href="{{ route('login') }}" class="btn btn-success btn-sm">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="me-1">
              <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
              <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
            </svg>
            Sign In
          </a>
          <a href="{{ route('register') }}" class="btn btn-outline-success btn-sm d-none d-sm-inline-block">Register</a>
        </div>
        @endauth
      </div>
    </div>
  </div>
</header>

<style>
.search-result-item:hover { background-color: #f8f9fa; }
#searchResults { border: 1px solid #dee2e6; border-top: none; }
header { font-family: 'Poppins', sans-serif; }
header .btn { font-weight: 500; }
</style>