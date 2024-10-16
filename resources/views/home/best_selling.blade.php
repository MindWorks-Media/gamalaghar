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
                        <div class="row margin-minus-b-30">
                            @foreach ($feauturedProducts as $productData)
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 mb-6 pro-gl-content">
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
                                                <span class="ec-price px-3 mb-3">
                                                    @if ($productData->productsizeprice->isNotEmpty())
                                                        <span class="new-price">Rs.
                                                            {{ $productData->productsizeprice->first()->price }}</span>
                                                    @endif
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
    </div>
</section>
<!-- Grocery section End -->
