@include('layout.header')
@include('layout.nav')
<!-- User profile section -->
<section class="ec-page-content ec-vendor-uploads ec-user-account section-space-p">
    <div class="container">
        <div class="row">
            <!-- Sidebar Area Start -->
            <div class="ec-shop-leftside ec-vendor-sidebar col-lg-3 col-md-12">
                <div class="ec-sidebar-wrap ec-border-box">
                    <!-- Sidebar Category Block -->
                    <div class="ec-sidebar-block">
                        <div class="ec-vendor-block">
                            <div class="ec-vendor-block-items">
                                <ul>
                                    <li><a href="{{ route('user.profile') }}" style="color: white">User Profile</a></li>
                                    <li><a href="{{ url('user/history') }}" style="color: white">Order History</a></li>
                                    <li><a href="{{ url('wishlist') }}" style="color: white">Wishlist</a></li>
                                    <li><a href="{{ url('cart') }}" style="color: white">Cart</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ec-shop-rightside col-lg-9 col-md-12">
                <div class="ec-vendor-dashboard-card ec-vendor-setting-card">
                    <div class="ec-vendor-card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="ec-vendor-block-profile">
                                    <div class="ec-vendor-block-img space-bottom-30">
                                        <div class="ec-vendor-block-bg">
                                            <a href="#" class="btn btn-lg btn-primary"
                                                data-link-action="editmodal" title="Edit Detail" data-bs-toggle="modal"
                                                data-bs-target="#edit_modal">Edit Detail</a>
                                        </div>
                                        <div class="ec-vendor-block-detail">
                                            @php
                                            $user = \App\Models\User::find(auth()->user()->id);
                                            $imageUrl = $user->getFirstMediaUrl('user_image');
                                        @endphp
                                            <img class="v-img" src="{{ $imageUrl ?: Avatar::create($user->name)->toBase64() }}"
                                                alt="{{ $user->name }}">
                                            <h5 class="name">{{ $user->name }}</h5>
                                        </div>
                                        <p>Hello <span class="user-profile">{{ $user->name }}!</span></p>
                                        <p>From your account you can easily view and track orders. You can manage and
                                            change your account information like address, contact information and
                                            history of orders.</p>
                                    </div>
                                    <h5>Account Information</h5>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <strong class="user-profile">E-mail Address : </strong>
                                            <div class="ec-vendor-detail-block ec-vendor-block-email space-bottom-30">
                                                <h6>{{ $user->email }} <a href="javasript:void(0)"
                                                        data-link-action="editmodal" title="Edit Detail"
                                                        data-bs-toggle="modal" data-bs-target="#edit_modal"><i
                                                            class="fi-rr-edit"></i></a></h6>
                                                <ul>
                                                    <li>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <strong class="user-profile">Contact number : </strong>
                                            <div class="ec-vendor-detail-block ec-vendor-block-contact space-bottom-30">
                                                <h6>{{ $user->phone }}
                                                    <a href="javasript:void(0)" data-link-action="editmodal"
                                                        title="Edit Detail" data-bs-toggle="modal"
                                                        data-bs-target="#edit_modal"><i class="fi-rr-edit"></i></a>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="ec-vendor-detail-block ec-vendor-block-address mar-b-30">
                                                <strong class="user-profile">Address :</strong>
                                                <h6>
                                                    @if ($user->userDetail)
                                                        {{ $user->userDetail->address }}
                                                    @else
                                                        No Address Added
                                                    @endif
                                                    <a href="javasript:void(0)" data-link-action="editmodal"
                                                        title="Edit Detail" data-bs-toggle="modal"
                                                        data-bs-target="#edit_modal"><i class="fi-rr-edit"></i></a>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End User profile section -->
@include('user.edit_details')
@include('layout.footer')
