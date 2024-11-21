@section('metadata')
    <x-meta title="Gamala Ghar"
        description="Gamala Ghar is an innovative ecommerce platform dedicated to providing a wide range of
                            indoor plants to enhance the ambiance and freshness of homes. With a focus on promoting
                            well-being and creating healthier living spaces, Gamala Ghar offers a curated selection
                            of indoor plants that are not only visually appealing but also contribute to improving
                            indoor air quality and overall mood."
        image="{{ url('assets/img/gamala-ghar-logo.png') }}" />
    <meta name="title" property="og:title" content="Gamalaghar">
    <meta name="description" property="og:description" content="Gamalaghar">
    <meta name="keywords" content="Gamalaghar">
    <meta name="author" content="Gamalaghar Ecommerce">
@endsection

@include('layout.header')
@livewireStyles
@include('layout.nav')

<!-- Best Selling section start -->
<section class="section ec-grocery-sec section-space-ptb-80 section-space-m" id="best-selling-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-title">
                    <h2 class="ec-title">ALL SELLING PRODUCTS</h2>
                    <p class="sub-title">Browse The Collection of Top Products</p>
                </div>
            </div>
        </div>
        <div class="row best-selling-side">
            <!-- Compare Content Start -->
            <div class="ec-wish-rightside col-lg-12 col-md-12">
                <!-- Compare content Start -->
                <div class="ec-compare-content">
                    <div class="ec-compare-inner">
                        <div class="row margin-minus-b-30 product-grid">
                            @foreach ($all_products as $productData)
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-6 pro-gl-content">
                                    <div class="ec-product-inner">
                                        <a href="{{ url('product/' . $productData->slug) }}">
                                            <div class="ec-pro-image-outer">
                                                <div class="ec-pro-image">
                                                    <div class="image">
                                                        @if ($productData->productImages->isNotEmpty())
                                                            @php
                                                                $firstImage = $productData->productImages->first();
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
                                                                src="{{ $productData->getFirstMediaUrl('product_image') }}"
                                                                alt="Product" />
                                                        @endif
                                                    </div>
                                                    @if ($productData->discount)
                                                        <span class="percentage">{{ $productData->discount }}%</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="ec-pro-content">
                                                <h5 class="ec-pro-title">
                                                    <a href="{{ url('product/' . $productData->slug) }}"
                                                        class="product-title"
                                                        data-full-title="{{ $productData->product_name }}">
                                                        <span class="full-title">{{ $productData->product_name }}</span>
                                                        <span
                                                            class="mobile-title">{{ Str::words($productData->product_name, 2, '...') }}</span>
                                                    </a>
                                                </h5>
                                                <div class="ec-pro-rating px-3" style="margin-left: 5px">
                                                    <div class="average_user_rating"
                                                        lay-options="{value: {{ $averageRatingValues[$productData->id] ?? 0 }}, theme: '#FF8000'}">
                                                    </div>

                                                </div>
                                                <span class="ec-price px-3 mb-1" style="margin-left: 5px">
                                                    @if ($productData->productsizeprice->isNotEmpty())
                                                        <span class="new-price">Rs.
                                                            {{ $productData->productsizeprice->first()->price }}</span>
                                                    @endif
                                                </span>

                                            </div>
                                            <div class="ec-pro-content">


                                                @auth
                                                    <span class="ec-price px-3 mb-3 " style="gap: 10px; margin-left:5px">
                                                        <a href="#" class="add-to-cart-btn2 w-100 text-center"
                                                            data-product-id="{{ $productData->id }}">Add
                                                            to Cart</a>
                                                        <a href="{{ url('product/' . $productData->slug) }}"
                                                            class="buy-now-btn w-100 text-center">Buy
                                                            Now</a>
                                                    </span>
                                                @else
                                                    <span class="ec-price px-3 mb-3 " style="gap: 10px; margin-left:5px">
                                                        <a href="#" class="add-to-cart-btn w-100 text-center"
                                                            data-product-id="{{ $productData->id }}"
                                                            data-sizeprice-id="{{ $productData->productsizeprice->first()->id }}"
                                                            data-name="{{ $productData->product_name }}"
                                                            data-price="{{ $productData->productsizeprice->first()->price }}"
                                                            data-image-url="{{ $firstMedia->getUrl() }}">Add
                                                            to Cart</a>
                                                        <a href="{{ url('product/' . $productData->slug) }}"
                                                            class="buy-now-btn w-100 text-center">Buy
                                                            Now</a>
                                                    </span>
                                                @endauth
                                            </div>
                                        </a>
                                        @auth
                                            @php
                                                $isInWishlist = \App\Models\Wishlist::where('user_id', auth()->id())
                                                    ->where('product_id', $productData->id)
                                                    ->exists();
                                            @endphp
                                            <span class="wish-icon {{ $isInWishlist ? 'glow' : '' }}"
                                                data-product-id="{{ $productData->id }}"><i class="fi-rr-heart"
                                                    style="font-size: 25px"></i></span>
                                        @endauth
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div>
                            {{ $all_products->links('pagination::bootstrap-5') }}
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
@livewireScripts
</body>

</html>
