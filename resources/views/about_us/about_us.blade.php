@include('layout.header')
@include('layout.nav')
<!-- Ec breadcrumb start -->
<div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row ec_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12">
                        <h2 class="ec-breadcrumb-title">About Us</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!-- ec-breadcrumb-list start -->
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="ec-breadcrumb-item active">About Us</li>
                        </ul>
                        <!-- ec-breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Ec breadcrumb end -->
<!-- Ec About Us page -->
<section class="ec-page-content section-space-p">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-title">
                    <h2 class="ec-bg-title">About Us</h2>
                    <h2 class="ec-title">About Us</h2>
                </div>
            </div>
            <div class="ec-common-wrapper">
                <div class="row">
                    <div class="col-md-6 ec-cms-block ec-abcms-block text-center">
                        <div class="ec-cms-block-inner">
                            <img class="a-img mt-5" src="{{ url('assets/img/gamala-ghar-banner.jpg') }}" alt="about">
                        </div>
                    </div>
                    <div class="col-md-6 ec-cms-block ec-abcms-block text-center">
                        <div class="ec-cms-block-inner">
                            <h3 class="ec-cms-block-title">What is Gamala Ghar?</h3>
                            <p>Gamala Ghar is an innovative ecommerce platform dedicated to providing a wide range of
                                indoor plants to enhance the ambiance and freshness of homes. With a focus on promoting
                                well-being and creating healthier living spaces, Gamala Ghar offers a curated selection
                                of indoor plants that are not only visually appealing but also contribute to improving
                                indoor air quality and overall mood.</p>
                            <p>Indoor plants have been scientifically proven to have numerous benefits beyond just
                                aesthetics. They have the ability to boost mood, increase creativity, reduce stress, and
                                eliminate air pollutants, creating a more conducive environment for relaxation and
                                productivity. Gamala Ghar recognizes the importance of these benefits and aims to make
                                them accessible to everyone through its convenient online platform.</p>
                            <p>At Gamala Ghar, customers can explore a diverse array of indoor plants suitable for
                                various preferences and living spaces. Whether it's lush foliage plants like peace
                                lilies and snake plants, or flowering varieties like orchids and begonias, there's
                                something for every taste and style. Each plant is carefully sourced and selected to
                                ensure optimum health and vitality upon delivery.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@include('layout.footer')
