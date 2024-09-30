@include('layout.header')
@include('layout.nav')
<!-- Ec breadcrumb start -->
<div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row ec_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12">
                        <h2 class="ec-breadcrumb-title">Cart</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!-- ec-breadcrumb-list start -->
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="{{ url('profile') }}">Profile</a></li>
                            <li class="ec-breadcrumb-item active">Cart</li>
                        </ul>
                        <!-- ec-breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Ec breadcrumb end -->
<!-- Ec cart page -->
<section class="ec-page-content section-space-p">
    <div class="container">
        <div class="row">
            <div class="ec-cart-leftside col-lg-12 col-md-12 ">
                <!-- cart content Start -->
                <div class="ec-cart-content">
                    <div class="ec-cart-inner">
                        <div class="row">
                            <form action="{{ url('user/checkouts') }}" method="POST">
                                @csrf
                                <div class="table-content cart-table-content">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th style="text-align: center;">Quantity</th>
                                                <th>Size</th>
                                                <th>Total</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($cart as $cartData)
                                                <tr>
                                                    <td><input type="checkbox" name="selectedProducts[]"
                                                            class="form-check-input" value="{{ $cartData->cartid }}">
                                                    </td>
                                                    @foreach ($cartproductImages as $cartproductImage)
                                                        @if ($cartproductImage->id == $cartData->id)
                                                            <td data-label="Product" class="ec-cart-pro-name">
                                                                <a>
                                                                    @if ($cartproductImage->productImages->isNotEmpty())
                                                                        @php
                                                                            $firstImage = $cartproductImage->productImages->first();
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
                                                                            src="{{ $cartproductImage->getFirstMediaUrl('product_image') }}"
                                                                            alt="Product" />
                                                                    @endif
                                                                </a>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                    <td data-label="Price" class="ec-cart-pro-price"><span
                                                            class="amount">Rs. {{ $cartData->price }}</span>
                                                    </td>
                                                    <td data-label="Quantity" class="ec-cart-pro-qty"
                                                        style="text-align: center;">
                                                        <div class="cart-qty-plus-minus">
                                                            <input class="qty-input quantityInput" type="text"
                                                                name="quantity" value="{{ $cartData->quantity }}" />
                                                        </div>
                                                    </td>
                                                    <td><span class="size">{{ $cartData->size }}</span></td>
                                                    <td data-label="Total" class="ec-cart-pro-subtotal">
                                                        <!-- Use a span with a unique id for the subtotal -->
                                                        <span id="subtotal">Rs.
                                                            {{ $cartData->price * $cartData->quantity }}</span>
                                                    </td>
                                                    <td data-label="Remove" class="ec-cart-pro-remove">
                                                        <a href="{{ url('cart/delete/' . $cartData->cartid) }}"><i
                                                                class="ecicon eci-trash-o"></i></a>

                                                        <a class="updateQuantityLink"
                                                            href="{{ url('cart/update/' . $cartData->cartid . '?quantity=' . $cartData->quantity) }}"><i
                                                                class="bx bx-edit-alt"></i></a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5">
                                                        <img src="{{ url('assets/img/Empty-rafiki.png') }}"
                                                            alt="Wishlist image" class="img-fluid d-block mx-auto"
                                                            style="max-width: 300px;" />
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="ec-cart-update-bottom">
                                            <a href="{{ url('/') }}">Continue Shopping</a>
                                            <button class="btn btn-primary">Check Out</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--cart content End -->
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        $('.quantityInput').on('input', function() {
            var newQuantity = $(this).val();
            var updateLink = $(this).closest('tr').find('.updateQuantityLink').attr('href');
            var updatedLink = updateLink.split('?')[0] + '?quantity=' + newQuantity;
            $(this).closest('tr').find('.updateQuantityLink').attr('href', updatedLink);
        });
    });
</script>
@include('user.new_product')
@include('layout.footer')
