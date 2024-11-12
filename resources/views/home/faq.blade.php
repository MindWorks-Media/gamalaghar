<!-- faq sec Start -->
<section class="ec-faq-sec section-space-p sec-background">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8 col-md-12">
                <div class="faq-detail">
                    <div class="faq-title">
                        <h3>Find frequently asked questions and
                            important information about us</h3>
                    </div>
                    <div class="accordion" id="accordion">
                        @foreach ($faqs as $faq)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $faq->id }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $faq->id }}" aria-expanded="false" aria-controls="collapse{{ $faq->id }}">
                                        {{ $faq->question }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $faq->id }}"
                                    data-bs-parent="#accordion">
                                    <div class="accordion-body">
                                        {{ $faq->answer }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-6 col-md-12">
                <div class="faq-img">
                    <img src="{{ url('assets/img/faq.png') }}" alt="">
                </div>
            </div> --}}
        </div>
    </div>
</section>
<!-- faq sec End -->
