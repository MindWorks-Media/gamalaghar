@include('layout.header')
@include('layout.nav')
<!-- User history section -->
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
                                    <li><a href="{{ url('profile') }}">User Profile</a></li>
                                    <li><a href="{{ url('user/history') }}">Order History</a></li>
                                    <li><a href="{{ url('wishlist') }}">Wishlist</a></li>
                                    <li><a href="{{ url('cart') }}">Cart</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ec-shop-rightside col-lg-9 col-md-12">
                <div class="ec-vendor-dashboard-card">
                    <div class="ec-vendor-card-header">
                        <h5>Order History</h5>
                        <div class="ec-header-btn">
                            <a class="btn btn-lg btn-primary" href="#">Shop Now</a>
                        </div>
                    </div>
                    <div class="ec-vendor-card-body">
                        <div class="ec-vendor-card-table">
                            <table class="table ec-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Image</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Size</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>

                                @forelse ($order_histories as $order_id => $orderItems)
                                    <tbody style="border-top: 0.8em solid transparent">
                                        <tr>
                                            <th colspan="3"  style="color: #692c91 !important;">Order Number:
                                                {{ $orderItems->first()->order->order_number ?? 'N/A' }}
                                            </th>
                                            <th colspan="3"  style="color: #692c91 !important;">Rs:
                                                {{ $orderItems->first()->order->total_amount ?? 'N/A' }}
                                            </th>
                                            <!-- Display order_number -->
                                        </tr>
                                        @foreach ($orderItems as $order_history)
                                            <tr>
                                                <td>
                                                    @foreach ($orderproductImages as $orderproductImage)
                                                        @if ($orderproductImage->id == $order_history->product_id)
                                                            @if ($orderproductImage->productImages->isNotEmpty())
                                                                @php
                                                                    $firstImage = $orderproductImage->productImages->first();
                                                                    $firstMedia = $firstImage
                                                                        ->getMedia('product_image')
                                                                        ->first();
                                                                @endphp

                                                                @if ($firstMedia)
                                                                    <img src="{{ $firstMedia->getUrl() }}"
                                                                        class="prod-img">
                                                                @endif
                                                            @else
                                                                <img class="prod-img"
                                                                    src="{{ $orderproductImage->getFirstMediaUrl('product_image') }}"
                                                                    alt="Product" />
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td><span>{{ $order_history->product_name }}<b>{{" x " . $order_history->quantity}}</b></span> </td>
                                                <td><span>{{ $order_history->size }}</span></td>
                                                <td><span>Rs. {{ $order_history->quantity * $order_history->price }}</span></td>
                                                <td><span class="tbl-btn"><a class="btn btn-lg btn-primary"
                                                            href="{{route('history.order-details', ['id' => $order_id])}}">View</a></span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    
                                @empty
                                    <tr>
                                        <td colspan="5">No order history found.</td>
                                    </tr>
                                @endforelse
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End User history section -->

@include('layout.footer')
