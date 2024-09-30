@include('layout.header')
@include('layout.nav')
<!-- Start Register -->
<section class="ec-page-content section-space-p">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-title">
                    <h2 class="ec-bg-title">Register</h2>
                    <h2 class="ec-title">Register</h2>
                    <p class="sub-title mb-3">Create an account for faster shopping experience</p>
                </div>
            </div>
            <div class="ec-register-wrapper">
                <div class="ec-register-container">
                    <div class="ec-register-form">
                        <form action="{{ url('register') }}" method="post">
                            @csrf
                            <span class="ec-register-wrap">
                                <label>Full Name<span class="layui-font-red">*</span></label>
                                <input type="text" name="fullname" placeholder="Enter your full name" />
                                @error('fullname')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </span>
                            <span class="ec-register-wrap ec-register-half">
                                <label>Email<span class="layui-font-red">*</span></label>
                                <input type="email" name="email" placeholder="Enter your email address" />
                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </span>
                            <span class="ec-register-wrap ec-register-half">
                                <label>Phone Number<span class="layui-font-red">*</span></label>
                                <input type="text" name="phone" placeholder="Enter your phone number" />
                                @error('phone')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </span>
                            <span class="ec-register-wrap ec-register-half">
                                <label>Password<span class="layui-font-red">*</span></label>
                                <input type="password" name="password" placeholder="Enter your password" />
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </span>
                            <span class="ec-register-wrap ec-register-half">
                                <label>Confirm Password<span class="layui-font-red">*</span></label>
                                <input type="password" name="confirm_password" placeholder="Confirm Your Password" />
                                @error('confirm_password')
                                    {{ $message }}
                                @enderror
                            </span>
                            <span class="ec-register-wrap ec-recaptcha">
                                <span class="g-recaptcha" data-sitekey="6LfKURIUAAAAAO50vlwWZkyK_G2ywqE52NU7YO0S"
                                    data-callback="verifyRecaptchaCallback"
                                    data-expired-callback="expiredRecaptchaCallback"></span>
                                <input class="form-control d-none" data-recaptcha="true"
                                    data-error="Please complete the Captcha">
                                <span class="help-block with-errors"></span>
                            </span>
                            <span class="ec-register-wrap ec-register-btn">
                                <button class="btn btn-primary" type="submit">Register</button>
                                <a href="{{ URL::to('googleLogin2') }}"><img
                                        src="{{ url('assets/img/google_signin.png') }}" class="mx-auto d-block"
                                        style="max-width: 200px;" /></a>

                            </span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Register -->
@include('layout.footer')
