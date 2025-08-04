{{-- Header Navigation --}}
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                <i class="fas fa-store me-2"></i>ECommerce Store
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                {{-- Main Navigation --}}
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown">
                            Categories
                        </a>
                        <ul class="dropdown-menu">
                            @php
                                $headerCategories = \Illuminate\Support\Facades\DB::table('categories')->orderBy('name')->get();
                            @endphp
                            @foreach($headerCategories as $category)
                                <li><a class="dropdown-item" href="{{ url('/category/' . $category->slug) }}">{{ $category->name }}</a></li>
                            @endforeach
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ url('/categories') }}">All Categories</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/products') }}">All Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/contact') }}">Contact</a>
                    </li>
                </ul>

                {{-- Search Form --}}
                <form class="d-flex me-3" method="GET" action="{{ url('/search') }}">
                    <div class="input-group">
                        <input class="form-control" type="search" name="query" placeholder="Search products..." 
                               value="{{ request('query') }}" aria-label="Search">
                        <button class="btn btn-outline-light" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

                {{-- User Navigation --}}
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus me-1"></i>Register
                                </a>
                            </li>
                        @endif
                    @else
                        {{-- Shopping Cart --}}
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="{{ url('/cart') }}">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ session('cart') ? count(session('cart')) : 0 }}
                                </span>
                            </a>
                        </li>
                        
                        {{-- User Dropdown --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(Auth::user() && \Illuminate\Support\Facades\DB::table('users')->where('id', Auth::id())->value('role') === 'admin')
                                    <li><a class="dropdown-item" href="{{ url('/admin') }}">
                                        <i class="fas fa-cog me-2"></i>Admin Panel
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ url('/orders') }}">
                                    <i class="fas fa-box me-2"></i>My Orders
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a></li>
                            </ul>
                        </li>
                        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>
