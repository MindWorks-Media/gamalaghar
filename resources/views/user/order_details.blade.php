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
                    <div class="ec-vendor-card-header p-4">
                        <h5># Order {{$order->order_number}}</h5>
                        <div class="ec-header-btn">
                            <p class="mb-0 text-muted">{{ $order->created_at->format('d M, Y h:i A') }}</p>
                        </div>
                    </div>
                    <div class="ec-vendor-card-body p-4">
                        <div class="ec-vendor-card-table overflow-hidden">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12 p-0">
                                        <div class="product-add global-shadow px-sm-30 py-sm-50 px-0 py-20 bg-white radius-xl w-100 mb-40">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="table-responsive">
                                                        <table class="table mb-0 table-borderless" id="table_data">
                                                            <thead style="background-color: #692c91;" class="text-light">
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>Product Image</th>
                                                                    <th>Product Code</th>
                                                                    <th>Product Name</th>
                                                                    <th>Quantity</th>
                                                                    <th>Price</th>
                                                                    <th>Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="border-bottom">
                                                                <tr>
                    
                                                                </tr>
                                                                @forelse ($order->orderItems as $orderItems)
                                                                    <tr class="border-bottom">
                                                                        <td>{{ $orderItems->id }}</td>
                                                                        <td>
                                                                            @foreach ($productImages as $productImage)
                                                                                @if ($productImage->id == $orderItems->product_id)
                                                                                    <img src="{{ $productImage->getFirstMediaUrl('product_image') }}"
                                                                                        alt="{{ $orderItems->product_name }}"
                                                                                        style="max-width: 100px" />
                                                                                @endif
                                                                            @endforeach
                                                                        </td>
                    
                                                                        <td>{{ $orderItems->product ? $orderItems->product->product_code : "-" }}</td>
                                                                        <td>{{ $orderItems->product_name }}</td>
                                                                        <td>{{ $orderItems->quantity }}</td>
                                                                        <td>{{ $orderItems->price }}</td>
                                                                        <td>{{ $orderItems->quantity * $orderItems->price }}</td>
                                                                    </tr>
                    
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="11">
                                                                            <img src="{{ url('assets/img/No data-rafiki.png') }}"
                                                                                class="img-fluid d-block mx-auto"
                                                                                style="max-width: 300px" />
                                                                        </td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td class="border-none" colspan="4">
                                                                        <span></span>
                                                                    </td>
                                                                    <td class="border-color" colspan="1">
                                                                        <span><strong>Sub Total</strong></span>
                                                                    </td>
                                                                    <td class="border-color">
                                                                        <span><b>Rs. {{ $order->sub_total }}</b></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="border-none" colspan="4">
                                                                        <span></span>
                                                                    </td>
                                                                    <td class="border-color" colspan="1">
                                                                        <span><strong>Delivery Charge</strong></span>
                                                                    </td>
                                                                    <td class="border-color">
                                                                        <span><b>Rs. {{ $order->delivery_charge }}</b></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="border-none" colspan="4">
                                                                        <span></span>
                                                                    </td>
                                                                    <td class="border-color" colspan="1">
                                                                        <span><strong>Total</strong></span>
                                                                    </td>
                                                                    <td class="border-color">
                                                                        <span><b>Rs. {{ $order->total_amount }}</b></span>
                                                                    </td>
                    
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- category table ends --}}
                                            <hr style="height:2px;border-width:0;color:gray;background-color:gray" class="my-4">
                    
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4 class="mb-3">Customer Details</h4>
                                                    <p class="mb-1"><strong>Name:</strong> {{ $order->user->name }}</p>
                                                    <p class="mb-1"><strong>Email:</strong> {{ $order->user->email }}</p>
                                                    <p class="mb-1"><strong>Phone:</strong> {{ $order->user->phone }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <h4 class="mb-3">Shipping Details</h4>
                                                    <p class="mb-1"><strong>Name:</strong> {{ $order->fullname }}</p>
                                                    <p class="mb-1"><strong>Email:</strong> {{ $order->shipping_email ? $order->shipping_email : $order->user->email }}</p>
                                                    <p class="mb-1"><strong>Phone:</strong> {{ $order->shipping_phone ? $order->shipping_phone : $order->user->phone }}</p>
                                                    <p class="mb-1"><strong>Address:</strong> {{ $order->province . ", " . $order->city . ", " . $order->area . ", " . $order->shipping_address }}</p>
                                                    {{-- <p><strong>Order Time:</strong> {{ $order->created_at }}</p> --}}
                                                </div>
                                                @if ($order->comment)  
                                                    <div class="col-12">
                                                        <h4 class="mb-3">Comment</h4>
                                                        <p class="mb-1">{{ $order->comment }}</p>
                                                    </div>
                                                @endif
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
<!-- End User history section -->

@include('layout.footer')
