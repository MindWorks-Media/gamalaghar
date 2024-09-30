<!-- bottom banner sec Start -->
<div class="flex align-items-center justify-center newsletter"
    style="background-image: url('{{ asset('assets/img/News_Letter.png') }}')">
    <div class="md:container mx-auto">
        <div class="flex justify-center">
            <div class="newsletter-container">
                <div class="newsletter-content">
                    <div class="items">
                        <div class="signup text-xl fw-bold">
                            <span>Sign Up For Newsletter</span>
                        </div>
                        <div class="detail small fw-normal py-1">
                            <span>Be the First to know. Sign up for the newsletter today</span>
                        </div>
                        <div class="newsletter-email py-2">
                            <form action="{{ url('newsletter') }}" method="POST">
                                @csrf
                                <div class="py-1 email-wrap">
                                    <input class="email" type="email" placeholder="Your email address"
                                        name="email">
                                </div>
                                <div class="sub-wrap">
                                    <button class="sub" type="submit">Subscribe</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- bottom banner sec end -->
