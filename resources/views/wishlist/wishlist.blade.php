@include('layout.header')
@include('layout.nav')
<!-- Ec Wishlist page -->
<section class="ec-page-content section-space-p">
    <div class="container">
        <div class="row">
            <!-- Sidebar Area Start -->
            <div class="ec-shop-leftside ec-vendor-sidebar col-lg-3 col-md-12">
                <div class="ec-sidebar-wrap ec-border-box">
                    <!-- Sidebar Category Block -->
                    <div class="ec-sidebar-block">
                        <div class="ec-vendor-block">
                            <div class="ec-vendor-block-items">
                                <ul>
                                    <li><a href="{{ url('profile') }}">User Profile</a></li>
                                    <li><a href="{{ url('user/history') }}">Order History</a></li>
                                    <li><a href="{{ url('wishlist') }}">Wishlist</a></li>
                                    <li><a href="{{ url('cart') }}">Cart</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Compare Content Start -->
            <div class="ec-wish-rightside col-lg-9 col-md-12">
                <!-- Compare content Start -->
                <div class="ec-compare-content">
                    <div class="ec-compare-inner">
                        <div class="row margin-minus-b-30">
                            @auth
                                @forelse ($wishLists as $wishList)
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6 pro-gl-content">
                                        <div class="ec-product-inner">
                                            <a href="{{ url('product/' . $wishList->slug) }}">
                                                <div class="ec-pro-image-outer">
                                                    <div class="ec-pro-image">
                                                        <div class="image">
                                                            @foreach ($productImages as $productImage)
                                                                @if ($productImage->id == $wishList->id)
                                                                    @if ($productImage->productImages->isNotEmpty())
                                                                        @php
                                                                            $firstImage = $productImage->productImages->first();
                                                                            $firstMedia = $firstImage
                                                                                ->getMedia('product_image')
                                                                                ->first();
                                                                        @endphp

                                                                        @if ($firstMedia)
                                                                            <img src="{{ $firstMedia->getUrl() }}"
                                                                                class="main-image">
                                                                        @endif
                                                                    @else
                                                                        <img class="main-image"
                                                                            src="{{ $productImage->getFirstMediaUrl('product_image') }}"
                                                                            alt="Product" />
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        @if ($wishList->discount > 0)
                                                            <span class="percentage">20%</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="ec-pro-content">
                                                    <h5 class="ec-pro-title"><a
                                                            href="{{ url('product/' . $wishList->slug) }}">{{ $wishList->product_name }}</a>
                                                    </h5>
                                                    <div class="ec-pro-rating px-3">
                                                        <div class="average_user_rating"
                                                            lay-options="{value: {{ $averageRatingValue }}, theme: '#FF8000'}">
                                                        </div>
                                                    </div>
                                                    <span class="ec-price px-3">
                                                        <span class="new-price">Rs. {{ $wishList->price }}</span>
                                                    </span>
                                                    <span class="ec-com-remove ec-remove-wish">
                                                        <a href="{{ url('wishlist/delete/' . $wishList->wishlistid) }}">
                                                            <i class="ecicon eci-trash-o">
                                                            </i>
                                                        </a>
                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <img src="{{ url('assets/img/Empty-rafiki.png') }}" alt="Wishlist image"
                                        class="img-fluid d-block mx-auto" style="max-width: 300px;" />
                                @endforelse
                            @else
                                <h2 class="text-center m-5">Kindly proceed with logging in to access the wishlist.</h2>
                            @endauth
                        </div>
                    </div>
                </div>
                <!--compare content End -->
            </div>
            <!-- Compare Content end -->
        </div>
    </div>
</section>
@include('layout.footer')
