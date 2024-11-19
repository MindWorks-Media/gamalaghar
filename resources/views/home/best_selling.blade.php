<!-- Best Selling section start -->
<section class="section ec-grocery-sec section-space-ptb-80 section-space-m" id="best-selling-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-title">
                    <h2 class="ec-title">BEST SELLING PRODUCTS</h2>
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
                            @foreach ($feauturedProducts as $productData)
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
                                                <h5 class="ec-pro-title"><a
                                                        href="{{ url('product/' . $productData->slug) }}">{{ $productData->product_name }}</a>
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
                                                <span class="ec-price px-3 mb-3 " style="gap: 15px; margin-left:5px">
                                                    <a href="#" class="add-to-cart-btn w-100 text-center" data-product-id="{{$productData->id}}" data-name="{{$productData->product_name}}" data-price="{{ $productData->productsizeprice->first()->price }}" data-image-url="{{ $firstMedia->getUrl() }}">Add
                                                        to Cart</a>
                                                    <a href="{{ url('product/' . $productData->slug) }}"
                                                        class="buy-now-btn w-100 text-center">Buy
                                                        Now</a>
                                                </span>
                                            </div>
                                        </a>
                                       
                                        @auth
                                        @php
                                        $isInWishlist = \App\Models\Wishlist::where('user_id', auth()->id())
                                            ->where('product_id', $productData->id)
                                            ->exists();
                                         @endphp
                                            <span class="wish-icon {{ $isInWishlist ? 'glow' : '' }}" data-product-id="{{ $productData->id }}"><i class="fi-rr-heart"
                                                    style="font-size: 25px"></i></span>
                                        @endauth
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row mt-5 d-flex align-items-center justify-content-center">
                            <div class="col-md-4 d-flex align-items-center justify-content-center">
                                <a href="{{route('products')}}" class="btn btn-primary w-25">View All</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--compare content End -->
            </div>
            <!-- Compare Content end -->
        </div>
    </div>
</section>
<!-- Grocery section End -->

{{-- best categories --}}
<!-- Best Selling section start -->
<section class="section ec-grocery-sec section-space-ptb-80 section-space-m mt-4" id="best-selling-section">
    {{-- <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-title">
                    <h2 class="ec-title">TOP PLANT CATEGORIES</h2>
                    <p class="sub-title">Browse The Collection of Top Plant Categories</p>
                </div>
            </div>
        </div>
        <div class="row best-selling-side">
            <!-- Compare Content Start -->
            <div class="ec-wish-rightside col-lg-12 col-md-12">
                <!-- Compare content Start -->
                <div class="ec-compare-content">
                    <div class="ec-compare-inner">
                        <div class="row margin-minus-b-30">
                            @foreach ($subcats as $subcat)
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 mb-6 pro-gl-content">
                                    <div class="ec-product-inner">
                                        <a href="{{ url('products/' . $subcat->slug) }}">
                                            <div class="ec-pro-image-outer">
                                                <div class="ec-pro-image">
                                                    <div class="image">
                                                        <img src="{{ $firstMedia->getUrl() }}" class="main-image">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ec-pro-content">
                                                <h5 class="ec-pro-title"><a
                                                        href="{{ url('products/' . $subcat->slug) }}">{{ $subcat->sub_category }}</a>
                                                </h5>
                                                <div class="ec-pro-rating px-3">
                                                </div>
                                                <span class="ec-price px-3 mb-1" style="margin-left: 5px">
                                                    <span class="new-price">Plants</span>
                                                </span>
                                            </div>
                                            <div class="ec-pro-content">
                                                <span class="ec-price px-4 mb-3 " style="gap: 20px">
                                                    <a href="{{ url('products/' . $subcat->slug) }}"
                                                        style="border: 2px solid #b5b2b2; padding: 0px 5px;font-size: 12px;">View
                                                        Products</a>
                                                </span>
                                            </div>
                                        </a>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!--compare content End -->
            </div>
            <!-- Compare Content end -->
        </div>
    </div> --}}
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-title">
                    <h2 class="ec-title">TOP PLANT CATEGORIES</h2>
                    <p class="sub-title">Browse The Collection of Top Plant Categories</p>
                </div>
            </div>
        </div>
        <div class="row" style="overflow: hidden">
            <div class="col-12">
                <div class="swiper-signposting" id="1234">
                    <div class="swiper-wrapper">
                        @foreach ($subcats as $subcat)
                            <div class="swiper-slide">
                                <div class="col-lg-12 col-md-4 col-sm-6 col-xs-6 mb-6 pro-gl-content">
                                    <div class="ec-product-inner">
                                        <a href="{{ url('products/' . $subcat->slug) }}">
                                            <div class="ec-pro-image-outer">
                                                <div class="ec-pro-image">
                                                    <div class="image">
                                                        <img src="{{ $firstMedia->getUrl() }}" class="main-image">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ec-pro-content">
                                                <h5 class="ec-pro-title"><a
                                                        href="{{ url('products/' . $subcat->slug) }}">{{ $subcat->sub_category }}</a>
                                                </h5>
                                                <div class="ec-pro-rating px-3">
                                                </div>
                                                <span class="ec-price px-3 mb-1" style="margin-left: 5px">
                                                    <span class="new-price">Plants</span>
                                                </span>
                                            </div>
                                            <div class="ec-pro-content">
                                                <span class="ec-price px-3 mb-3 " style="gap: 20px; margin-left:5px">
                                                    <a href="{{ url('products/' . $subcat->slug) }}"
                                                        class="add-to-cart-btn">View
                                                        Products</a>
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- <div class="swiper-slide">
                    <a href="#" class="signposting-item h-100 d-flex flex-column text-center justify-space-between" aria-label="Slider title 2">
                      <div class="signposting-item-content">
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
                                    <h5 class="ec-pro-title"><a
                                            href="{{ url('product/' . $productData->slug) }}">{{ $productData->product_name }}</a>
                                    </h5>
                                    <div class="ec-pro-rating px-3">
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
                                    <span class="ec-price px-4 mb-3 " style="gap: 20px">
                                        <a href=""
                                            style="border: 2px solid #b5b2b2; padding: 0px 5px;font-size: 12px;">Add
                                            to Cart</a>
                                        <a href=""
                                            style="border: 2px solid #b5b2b2; padding: 0px 5px;font-size: 12px;">Buy
                                            Now</a>
                                    </span>
                                </div>
                            </a>
                            <span style="position: absolute;top: 18px; right: 22px;z-index: 100;"><i
                                    class="fi-rr-heart" style="font-size: 25px"></i></span>
                        </div>
                      </div>
                      <div class="button-wrap mt-auto">
                        <div class="button __inline">Find out more</div>
                      </div>
                    </a>
                  </div>
                  <div class="swiper-slide">
                    <a href="#" class="signposting-item h-100 d-flex flex-column text-center justify-space-between" aria-label="Slider title 3">
                      <div class="signposting-item-content">
                        <div class="signposting-item-icon">
                          <span class="material-symbols-outlined" aria-label="Diversity">
                            diversity_1
                          </span>
                        </div>
                        <div class="h4 signposting-item-title" role="heading" aria-level="3">Slider sitle 3</div>
                        <p class="">This is the slider text</p>
                      </div>
                      <div class="button-wrap mt-auto">
                        <div class="button __inline">Find out more</div>
                      </div>
                    </a>

                  </div>
                  <div class="swiper-slide">
                    <a href="#" class="signposting-item h-100 d-flex flex-column text-center justify-space-between" aria-label="Slider title 4">
                      <div class="signposting-item-content">
                        <div class="signposting-item-icon">
                          <span class="material-symbols-outlined" aria-label="smile">
                            sentiment_satisfied
                          </span>
                        </div>
                        <div class="h4 signposting-item-title" role="heading" aria-level="3">Slider sitle 4</div>
                        <p class="">This is some much longer slider text which goes onto several rows</p>
                      </div>
                      <div class="button-wrap mt-auto">
                        <div class="button __inline">Find out more</div>
                      </div>
                    </a>
                  </div>
                  <div class="swiper-slide">
                    <a href="#" class="signposting-item h-100 d-flex flex-column text-center justify-space-between" aria-label="Slider title 5">
                      <div class="signposting-item-content">
                        <div class="signposting-item-icon">
                          <span class="material-symbols-outlined" aria-label="Forest">
                            forest
                          </span>
                        </div>
                        <div class="h4 signposting-item-title" role="heading" aria-level="3">Slider sitle 5</div>
                        <p class="">This is the slider text</p>
                      </div>
                      <div class="button-wrap mt-auto">
                        <div class="button __inline">Find out more</div>
                      </div>
                    </a>
                  </div>
                  <div class="swiper-slide">
                    <a href="#" class="signposting-item h-100 d-flex flex-column text-center justify-space-between" aria-label="Slider title 4">
                      <div class="signposting-item-content">
                        <div class="signposting-item-icon">
                          <span class="material-symbols-outlined" aria-label="Moon">
                            dark_mode

                          </span>
                        </div>
                        <div class="h4 signposting-item-title" role="heading" aria-level="3">Slider sitle 6</div>
                        <p class="">This is the slider text</p>
                      </div>
                      <div class="button-wrap mt-auto">
                        <div class="button __inline">Find out more</div>
                      </div>
                    </a>
                  </div>
                  <div class="swiper-slide">
                    <a href="#" class="signposting-item h-100 d-flex flex-column text-center justify-space-between" aria-label="Slider title 7">
                      <div class="signposting-item-content">
                        <div class="signposting-item-icon">
                          <span class="material-symbols-outlined" aria-label="Sun">
                            sunny
                          </span>
                        </div>
                        <div class="h4 signposting-item-title" role="heading" aria-level="3">Slider sitle 7</div>
                        <p class="">This is the slider text</p>
                      </div>
                      <div class="button-wrap mt-auto">
                        <div class="swip-button __inline">Find out more</div>
                      </div>
                    </a>
                  </div> --}}
                    </div>
                    <div class="slider-button-wrap d-flex justify-content-center"
                        style="gap:20px; font-size:30px;padding: 10px;">
                        <div class="slider-button-prev swiperSignpostingPrev"><span class="icon"><i
                                    class="fa-solid fa-chevron-left"></i></span></div>
                        <div class="slider-button-next swiperSignpostingNext"><span class="icon"><i
                                    class="fa-solid fa-chevron-right"></i></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.querySelectorAll('.swiper-signposting').forEach(function(thisSlider) {
        const id = thisSlider.id; // make sure your slider element has a unique ID
        const slider = document.getElementById(id);
        const container = slider.parentElement;

        const swiper = new Swiper(slider, {
            a11y: {
                prevSlideMessage: 'Previous slide',
                nextSlideMessage: 'Next slide',
            },
            navigation: {
                nextEl: container.querySelector('.swiperSignpostingNext'),
                prevEl: container.querySelector('.swiperSignpostingPrev'),
            },
            breakpoints: {
                0: {
                    slidesPerView: 1.2,
                    spaceBetween: 16,
                },
                576: {
                    slidesPerView: 2.2,
                    spaceBetween: 16,
                },
                992: {
                    slidesPerView: 3,
                    spaceBetween: 16,
                },
                1200: {
                    slidesPerView: 4,
                    spaceBetween: 16,
                },
            },
        });
    });

    document.querySelectorAll('.gallery .swiper-gallery').forEach(function(thisSlider) {
        const id = thisSlider.id; // make sure your slider element has a unique ID
        const slider = document.getElementById(id);
        const container = slider.closest('.gallery');

        const swiper = new Swiper(slider, {
            a11y: {
                enabled: true
            },
            navigation: {
                nextEl: container.querySelector('.swiperGalleryNext'),
                prevEl: container.querySelector('.swiperGalleryPrev'),
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                type: 'bullets',
            },
            renderBullet: function(index, className) {
                return '<span class="' + className + '">' + (index + 1) + '</span>';
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                    spaceBetween: 16,
                },
            },
        });
    });
</script>
