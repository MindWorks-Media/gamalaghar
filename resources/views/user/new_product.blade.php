<!-- Related Product Start -->
<section class="section ec-releted-product section-space-p">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-title">
                    <h2 class="ec-bg-title">Related products</h2>
                    <p class="sub-title">Browse The Collection of Top Products</p>
                </div>
            </div>
        </div>
        <div class="row margin-minus-b-30">
            <!-- Related Product Content -->
            @foreach ($relatedProducts as $relatedProduct)
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6 pro-gl-content">
                    <div class="ec-product-inner">
                        <a href="{{ url('product/' . $relatedProduct->slug) }}">
                            <div class="ec-pro-image-outer">
                                <div class="ec-pro-image">
                                    <div class="image">
                                        @if ($relatedProduct->productImages->isNotEmpty())
                                            @php
                                                $firstImage = $relatedProduct->productImages->first();
                                                $firstMedia = $firstImage->getMedia('product_image')->first();
                                            @endphp

                                            @if ($firstMedia)
                                                <img src="{{ $firstMedia->getUrl() }}" class="main-image">
                                            @endif
                                        @else
                                            <img class="main-image"
                                                src="{{ $relatedProduct->getFirstMediaUrl('product_image') }}"
                                                alt="Product" />
                                        @endif
                                    </div>
                                    <span class="percentage">{{ $relatedProduct->discount }}%</span>
                                </div>
                            </div>


                            <div class="ec-pro-content">
                                <h5 class="ec-pro-title"><a
                                        href="{{ url('product/' . $relatedProduct->slug) }}">{{ $relatedProduct->product_name }}</a>
                                </h5>
                                <div class="ec-pro-rating px-3" style="margin-left: 5px">
                                    <div class="average_user_rating"
                                        lay-options="{value: {{ $averageRatingValues[$relatedProduct->id] ?? 0 }}, theme: '#FF8000'}">
                                    </div>

                                </div>
                                <span class="ec-price px-3 mb-1" style="margin-left: 5px">
                                    @if ($relatedProduct->productsizeprice->isNotEmpty())
                                        <span class="new-price">Rs.
                                            {{ $relatedProduct->productsizeprice->first()->price }}</span>
                                    @endif
                                </span>

                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Related Product end -->
