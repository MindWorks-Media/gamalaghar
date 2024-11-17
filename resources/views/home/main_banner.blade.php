<!-- Main Banner Start -->
<div class="ec-main-slider section section-space-pb">
    <div class="" style="width: 100%; display: inline-block;">
        <div id="carouselExampleIndicators" class="carousel slide custom-carousel">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <div class="container d-flex align-self-center m-hit" >
                    <div class="row main-banner">
                        <div class="col-sm-12 align-self-center">
                            <div class="ec-slide-content slider-animation">
                                <h2 class="ec-slide-stitle">Indoor plants
                                    for your home</h2>
                                <h1 class="ec-slide-title">Make your home<span class="outline-txt">fresh</span></h1>
                                <div class="ec-slide-disc">
                                    <p>with Indoor Plants</p>
                                    <a href="#best-selling-section" class="btn btn-lg btn-primary"><span>Shop Now</span><i
                                            class="fi-rr-shopping-basket"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <img src="{{asset('assets/img/main_banner.webp')}}" class="d-block w-100 no-transform-transition" alt="..." >
              </div>
              <div class="carousel-item">
                <div class="container d-flex align-self-center m-hit">
                    <div class="row main-banner">
                        <div class="col-sm-12 align-self-center">
                            <div class="ec-slide-content slider-animation">
                                <h2 class="ec-slide-stitle">Indoor plants
                                    for your home</h2>
                                <h1 class="ec-slide-title">Make your home<span class="outline-txt">fresh</span></h1>
                                <div class="ec-slide-disc">
                                    <p>with Indoor Plants</p>
                                    <a href="#best-selling-section" class="btn btn-lg btn-primary"><span>Shop Now</span><i
                                            class="fi-rr-shopping-basket"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <img src="{{asset('assets/img/main_banner.webp')}}" class="d-block w-100 no-transform-transition" alt="...">
              </div>
              <div class="carousel-item">
                <div class="container d-flex align-self-center m-hit" >
                    <div class="row main-banner">
                        <div class="col-sm-12 align-self-center">
                            <div class="ec-slide-content slider-animation">
                                <h2 class="ec-slide-stitle">Indoor plants
                                    for your home</h2>
                                <h1 class="ec-slide-title">Make your home<span class="outline-txt">fresh</span></h1>
                                <div class="ec-slide-disc">
                                    <p>with Indoor Plants</p>
                                    <a href="#best-selling-section" class="btn btn-lg btn-primary"><span>Shop Now</span><i
                                            class="fi-rr-shopping-basket"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <img src="{{asset('assets/img/main_banner.webp')}}" class="d-block w-100 no-transform-transition" alt="...">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
    </div>
    {{-- <div class="ec-slider">
        <div class="ec-slide-item d-flex slide-1">
            <div id="carouselExampleIndicators" class="carousel slide">
                <div class="carousel-indicators">
                    @if ($product->productImages->isNotEmpty() && $product->productImages->count() > 1)
                        @foreach ($product->productImages as $index => $productImage)
                            <button type="button"
                                data-bs-target="#carouselExampleIndicators"
                                data-bs-slide-to="{{ $index }}"
                                class="{{ $index == 0 ? 'active' : '' }}"
                                aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    @endif
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                          <div class="container align-self-center">
                                <div class="row main-banner">
                                    <div class="col-sm-12 align-self-center">
                                        <div class="ec-slide-content slider-animation">
                                            <h2 class="ec-slide-stitle">Indoor plants
                                                for your home</h2>
                                            <h1 class="ec-slide-title">Make your home<span class="outline-txt">fresh</span></h1>
                                            <div class="ec-slide-disc">
                                                <p>with Indoor Plants</p>
                                                <a href="#best-selling-section" class="btn btn-lg btn-primary"><span>Shop Now</span><i
                                                        class="fi-rr-shopping-basket"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>

                @if ($product->productImages->count() > 1)
                    <button class="carousel-control-prev" type="button"
                        data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button"
                        data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                @endif
            </div>
        </div>
    </div> --}}

</div>
