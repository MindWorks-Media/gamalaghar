<!-- Header start  -->
<header class="ec-header">
    <!--Ec Header Top Start -->
    <div class="header-top">
        <div class="container">
            <div class="row align-items-center">

                <!-- Header Top Message Start -->
                <div class="col text-center header-top-center">
                    <div class="header-top-message">
                        100% secure delivery without contacting the courier
                    </div>
                </div>
                <!-- Header Top Message End -->
                <!-- Header Top Language Currency -->
                <div class="col header-top-right d-none d-lg-block">
                    <div class="header-top-lan-curr d-flex justify-content-end">
                        <!-- Phone Number   -->
                        <div class="header-top-message"><i class='bx bxs-phone' style='color:#692c91'></i> 9801890046
                        </div>
                    </div>
                </div>
                <!-- Header Top Language Currency -->
                <!-- Header Top responsive Action -->
                <div class="col d-lg-none ">
                    <div class="ec-header-bottons">
                        <!-- Header User Start -->
                        <div class="ec-header-user dropdown">
                            @auth
                                <button class="dropdown-toggle" data-bs-toggle="dropdown"><i
                                        class="fi-rr-user"></i></button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a class="dropdown-item" href="{{ url('profile') }}">My Account</a></li>
                                    <li>
                                        <form action="{{ url('logout') }}" method="POST">
                                            @csrf
                                            <button class="dropdown-item">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            @else
                                <button class="dropdown-toggle" data-bs-toggle="dropdown"><i
                                        class="fi-rr-user"></i></button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a class="dropdown-item" href="{{ url('register') }}">Register</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/login') }}">Login</a></li>
                                </ul>
                            @endauth
                        </div>
                        <!-- Header User End -->
                        <!-- Header Cart Start -->
                        <a href="{{ url('wishlist') }}" class="ec-header-btn ec-header-wishlist">
                            <div class="header-icon">
                                @if ($countWishList)
                                    <i class="fi-rr-heart"></i>
                                    <span class="ec-header-count">
                                        {{ $countWishList }}
                                    </span>
                                @else
                                    <i class="fi-rr-heart"></i>
                                @endif
                            </div>
                        </a>
                        <!-- Header Cart Start -->
                        <a href="#ec-side-cart" class="ec-header-btn ec-side-toggle">
                            <div class="header-icon">
                                @if ($countCarts)
                                    <i class="fi-rr-shopping-basket"></i>
                                    <span class="ec-header-count ec-cart-count cart-count-lable">
                                        {{ $countCarts }}
                                    </span>
                                @else
                                    <i class="fi-rr-shopping-basket"></i>
                                @endif
                            </div>
                        </a>
                        <a href="#ec-mobile-menu" class="ec-header-btn ec-side-toggle d-lg-none">
                            <i class="fi-rr-menu-burger"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header Top responsive Action -->
    </div>

    <!-- Ec Header Top  End -->
    <!-- Ec Header Bottom  Start -->
    <div class="ec-header-bottom d-none d-lg-block">
        <div class="container position-relative">
            <div class="row">
                <div class="ec-flex">
                    <!-- Ec Header Logo Start -->
                    <div class="align-self-center">
                        <div class="header-logo">
                            <a href="{{ url('/') }}"><img src="{{ url('assets/img/Logo.png') }}"
                                    alt="Site Logo" /><img class="dark-logo"
                                    src="{{ url('assets/img/logo-white.png') }}" alt="Site Logo"
                                    style="display: none;" /></a>
                        </div>
                    </div>
                    <!-- Ec Header Logo End -->

                    <!-- EC Main Menu Start -->
                    <div id="ec-main-menu-desk" class="d-none d-lg-block sticky-nav">
                        <div class="container position-relative">
                            <div class="row">
                                <div class="col-md-12 align-self-center">
                                    <div class="ec-main-menu">
                                        <ul>
                                            <li><a href="{{ url('/') }}">Home</a></li>
                                            @foreach ($mainCategory as $data)
                                                <li class="dropdown"><a
                                                        href="javascript:void(0)">{{ $data->main_category }}</a>
                                                    @if ($data->subcategories->isNotEmpty())
                                                        <ul class="sub-menu">
                                                            @foreach ($data->subcategories as $subCategory)
                                                                <li><a
                                                                        href="{{ url('products/' . $subCategory->slug) }}">{{ $subCategory->sub_category }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Ec Main Menu End -->

                    <!-- Ec Header Button Start -->
                    <div class="align-self-center">
                        <div class="ec-header-bottons">
                            <!-- Header User Start -->
                            <div class="ec-header-user dropdown">
                                @auth
                                    <button class="dropdown-toggle button" data-bs-toggle="dropdown"><span>My
                                            Account</span><i class="fi fi-rr-angle-small-down"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a class="dropdown-item" href="{{ url('profile') }}">Profile</a></li>
                                        <li><a class="dropdown-item" href="{{ url('user/history') }}">Order History</a></li>
                                        <li><a class="dropdown-item" href="{{ url('wishlist') }}">Wishlist</a></li>
                                        <li><a class="dropdown-item" href="{{ url('cart') }}">Cart</a></li>
                                        <li>
                                            <form action="{{ url('logout') }}" method="POST">
                                                @csrf
                                                <button class="dropdown-item">Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                @else
                                    <button class="dropdown-toggle button" data-bs-toggle="dropdown"><span>Login/Sign
                                            up</span><i class="fi fi-rr-angle-small-down"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a class="dropdown-item" href="{{ url('register') }}">Register</a>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ url('/login') }}">Login</a></li>
                                    </ul>
                                @endauth
                            </div>
                            <!-- Header User End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec Header Button End -->
    <!-- Ec Header Bottom  Start -->
    <div class="ec-header-bottom d-none d-lg-block">
        <div class="container position-relative">
            <div class="row">
                <div class="ec-flex">
                    <!-- Header cat Start -->
                    <div class="header-cat-btn ec-dropdown">
                        <button class="dropdown-toggle" data-bs-toggle="dropdown"><i
                                class="fi fi-rr-menu-burger"></i><span>Shop By Categories</span><i
                                class="fi fi-rr-angle-small-down"></i></button>
                        <ul class="sub-menu">
                            @foreach ($mainCategory as $category)
                                @if ($category->subcategories->isNotEmpty())
                                    @foreach ($category->subcategories as $subcategory)
                                        <li><a class="dropdown-item"
                                                href="{{ url('products/' . $subcategory->slug) }}">{{ $subcategory->sub_category }}</a>
                                        </li>
                                    @endforeach
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <!-- Header cat End -->

                    <!-- Ec Header Search Start -->
                    <div class="align-self-center">
                        <div class="header-search">
                            <form class="ec-btn-group-form" action="{{ url('products/search/view') }}"
                                method="get">
                                <input class="form-control" placeholder="Search Product Here..." type="text"
                                    name="search_keyword" id="search_keyword">
                                <button class="submit" type="submit"><i class="fi-rr-search"></i></button>
                            </form>
                        </div>
                    </div>
                    <!-- Ec Header Search End -->

                    <!-- Ec Header Button Start -->
                    <div class="align-self-center">
                        <div class="ec-header-bottons">
                            <!-- Header wishlist Start -->
                            <a href="{{ url('wishlist') }}" class="ec-header-btn ec-header-wishlist">
                                @if ($countWishList)
                                    <div class="header-icon"><i class="fi-rr-heart"></i></div>
                                    <span class="ec-header-count">
                                        {{ $countWishList }}
                                    </span>
                                @else
                                    <div class="header-icon"><i class="fi-rr-heart"></i></div>
                                @endif
                            </a>
                            <!-- Header wishlist End -->
                            <!-- Header Cart Start -->
                            <a href="#ec-side-cart" class="ec-header-btn ec-side-toggle">
                                @if ($countCarts)
                                    <div class="header-icon">
                                        <i class="fi-rr-shopping-basket"></i>
                                    </div>
                                    <span class="ec-header-count ec-cart-count cart-count-lable">
                                        {{ $countCarts }}
                                    </span>
                                @else
                                    <div class="header-icon">
                                        <i class="fi-rr-shopping-basket"></i>
                                    </div>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec Header Button End -->

    <div id="ec-mobile-menu" class="ec-side-cart ec-mobile-menu">
        <div class="ec-menu-title">
            <span class="menu_title">My Menu</span>
            <button class="ec-close">×</button>
        </div>
        <div class="ec-menu-inner">
            <div class="ec-menu-content">
                <ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    @foreach ($mainCategory as $data)
                        <li><a href="javascript:void(0)">{{ $data->main_category }}</a>
                            @if ($data->subcategories->isNotEmpty())
                                <ul class="sub-menu">
                                    @foreach ($data->subcategories as $subCategory)
                                        <li><a
                                                href="{{ url('products/' . $subCategory->slug) }}">{{ $subCategory->sub_category }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <!-- ekka mobile Menu End -->
</header>
<!-- Header End -->
