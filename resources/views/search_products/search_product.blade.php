@include('layout.header')
@include('layout.nav')
<!-- Ec Shop page -->
<style>
    /* Center the button */
    .button-container {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        /* Adjust spacing as needed */
    }
</style>
<section class="ec-page-content mb-4">
    <div class="container">
        <div class="row">
            <!-- Sidebar Area Start -->
            <div class="ec-shop-leftside col-lg-3 order-lg-first col-md-12 order-md-last">
                <div class="ec-sidebar-wrap">
                    <div class="ec-sidebar-heading">
                        <h1>Filter Products By</h1>
                    </div>
                    <!-- Sidebar Price Block -->
                    <div class="ec-sidebar-block">
                        <div class="ec-sb-title">
                            <h3 class="ec-sidebar-title">Price</h3>
                        </div>

                        <form id="priceFilterForm" action="{{ url('products/search/view') }}" method="GET">
                            <div class="ec-sb-block-content es-price-slider">
                                <div class="ec-price-filter">
                                    <div id="ec-sliderPrice" class="filter__slider-price" data-min="0"
                                        data-max="10000" data-step="10"></div>
                                    <div class="ec-price-input">
                                        <label class="filter__label">
                                            <input type="text" id="minPrice" class="filter__input" name="min_price">
                                        </label>
                                        <span class="ec-price-divider"></span>
                                        <label class="filter__label">
                                            <input type="text" id="maxPrice" class="filter__input" name="max_price">
                                        </label>
                                    </div>
                                </div>
                                <br>
                                <div class="button-container">
                                    <button class="btn btn-primary" type="submit">Update</button>
                                </div>
                            </div>

                        </form>


                    </div>
                </div>
            </div>
            <div class="ec-shop-rightside col-lg-9 order-lg-last col-md-12 order-md-first margin-b-30">
                <!-- Shop Top Start -->
                <div class="ec-pro-list-top d-flex">
                    <div class="col-md-6 ec-grid-list">
                        <div class="ec-gl-btn">
                            <button class="btn btn-grid active"><i class="fi-rr-apps"></i></button>

                        </div>
                    </div>
                    <div class="col-md-6 ec-sort-select">
                        <span class="sort-by">Sort by</span>
                        <div>
                            <form class="ec-btn-group-form" id="myForm" action="{{ url('products/search/view') }}"
                                method="get">
                                <select name="position" id="position">
                                    <option selected disabled>Position</option>
                                    <option value="low-to-high">Price, low to high</option>
                                    <option value="high-to-low">Price, high to low</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Shop Top End -->
                <!-- Shop content Start -->
                <div class="shop-pro-content">
                    <div class="shop-pro-inner">
                        <div class="row">
                            @forelse ($resultedProducts as $productData)
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 mb-6 pro-gl-content">
                                    <div class="ec-product-inner">
                                        <a href="{{ url('product/' . $productData->slug) }}">
                                            <div class="ec-pro-image-outer">
                                                <div class="ec-pro-image">
                                                    @if ($productData->productImages->isNotEmpty())
                                                        @php
                                                            $firstImage = $productData->productImages->first();
                                                            $firstMedia = $firstImage
                                                                ->getMedia('product_image')
                                                                ->first();
                                                        @endphp

                                                        @if ($firstMedia)
                                                            <img src="{{ $firstMedia->getUrl() }}" class="main-image">
                                                        @endif
                                                    @else
                                                        <img class="main-image"
                                                            src="{{ $productData->getFirstMediaUrl('product_image') }}"
                                                            alt="Product" />
                                                    @endif
                                                    @if ($productData->discount != null)
                                                        <span class="percentage">{{ $productData->discount }}%</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="ec-pro-content">
                                                <div class="ec-pro-title">
                                                    <a
                                                        href="{{ url('product/' . $productData->slug) }}">{{ $productData->product_name }}</a>
                                                </div>
                                                {{-- <div class="ec-pro-rating px-3" style="margin-left: 5px">
                                                    @for ($i = 0; $i < 4; $i++)
                                                        <i class="ecicon eci-star fill"></i>
                                                    @endfor
                                                    <i class="ecicon eci-star"></i>
                                                </div> --}}
                                                <span class="ec-price px-3 mb-1" style="margin-left: 5px">
                                                    @if ($productData->productsizeprice->isNotEmpty())
                                                        <span class="new-price">Rs.
                                                            {{ $productData->product_price }}</span>
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="ec-pro-content">
                                                <span class="ec-price px-3 mb-3 " style="gap: 15px; margin-left:5px">
                                                    <a href="#" class="add-to-cart-btn w-100 text-center" data-product-id="{{$productData->id}}" data-sizeprice-id="{{ $productData->productsizeprice->first()->id }}" data-name="{{$productData->product_name}}" data-price="{{ $productData->productsizeprice->first()->price }}" data-image-url="{{ $firstMedia->getUrl() }}">Add
                                                        to Cart</a>
                                                    <a href="{{ url('product/' . $productData->slug) }}"
                                                        class="buy-now-btn w-100 text-center">Buy
                                                        Now</a>
                                                </span>
                                            </div>
                                        </a>
                                        <span class="wish-icon"><i class="fi-rr-heart"
                                                style="font-size: 25px"></i></span>
                                    </div>
                                </div>
                            @empty
                                <img src="{{ url('assets/img/Empty-rafiki.png') }}" alt="Wishlist image"
                                    class="img-fluid d-block mx-auto" style="width: 40%" />
                            @endforelse

                        </div>
                        <div>
                            {{ $resultedProducts->links('pagination::bootstrap-5') }}
                        </div>
                        <!--Shop content End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Shop page -->




@include('layout.footer')

<script>
    $(document).ready(function() {
        var form = $('#priceFilterForm');

        // Initialize the slider with jQuery UI
        $("#ec-sliderPrice").slider({
            range: true,
            min: 0,
            max: 250,
            step: 10,
            values: [0, 250],
            slide: function(event, ui) {
                $("#minPrice").val(ui.values[0]);
                $("#maxPrice").val(ui.values[1]);
            },
            change: function(event, ui) {
                // Update the input fields
                $("#minPrice").val(ui.values[0]);
                $("#maxPrice").val(ui.values[1]);
                // Submit the form when slider values change
                form.submit();
            }
        });

        // Set initial values
        $("#minPrice").val($("#ec-sliderPrice").slider("values", 0));
        $("#maxPrice").val($("#ec-sliderPrice").slider("values", 1));
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        var form = document.getElementById('myForm');
        var select = document.getElementById('position');

        select.addEventListener('change', function() {
            // Execute any code you want here before the form submission
            // For example, you can log the selected value to the console
            console.log("Selected value:", select.value);

            // Then submit the form
            form.submit();
        });
    });
</script>
