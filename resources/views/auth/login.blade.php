@include('layout.header')
@include('layout.nav')

<!-- Ec login page -->
<section class="ec-page-content section-space-p">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-title">
                    <h2 class="ec-bg-title">Log In</h2>
                    <h2 class="ec-title">Log In</h2>
                    <p class="sub-title mb-3">Get a Faster Shopping Experience</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="ec-login-wrapper">
                    <div class="ec-login-container">
                        <div class="ec-login-form">
                            <form action="{{ url('login') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email Address<span class="layui-font-red">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="Enter your email address" required>
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">Password<span class="layui-font-red">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="Enter your password" required>
                                    @error('password')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <span class="ec-login-wrap ec-login-fp">
                                        <a href="#">Forgot Password?</a>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <span class="ec-login-wrap ec-login-btn">
                                        <button type="submit" class="btn btn-primary">Login</button>
                                        <a href="{{ url('register') }}" class="btn btn-secondary">Register</a>
                                        <a href="{{ URL::to('googleLogin2') }}" class="btn">
                                            <img src="{{ url('assets/img/google_signin.png') }}" class="mx-auto"
                                                style="max-width: 200px;" alt="Sign in with Google">
                                        </a>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('layout.footer')
