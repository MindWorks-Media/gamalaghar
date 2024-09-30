<!-- Ekka Cart Start -->
<div class="ec-side-cart-overlay"></div>
<div id="ec-side-cart" class="ec-side-cart">
    @auth
        <div class="ec-cart-inner">
            <div class="ec-cart-top">
                <div class="ec-cart-title">
                    <span class="cart_title">My Cart</span>
                    <button class="ec-close">×</button>
                </div>

                <ul class="eccart-pro-items">

                    @forelse ($cart as $cartData)
                        <li>
                            <div class="sidecart_pro_img">
                                @foreach ($cartproductImages as $cartproductImage)
                                    @if ($cartproductImage->id == $cartData->id)
                                        @if ($cartproductImage->productImages->isNotEmpty())
                                            @php
                                                $firstImage = $cartproductImage->productImages->first();
                                                $firstMedia = $firstImage->getMedia('product_image')->first();
                                            @endphp

                                            @if ($firstMedia)
                                                <img src="{{ $firstMedia->getUrl() }}" class="main-image">
                                            @endif
                                        @else
                                            <img class="main-image"
                                                src="{{ $cartproductImage->getFirstMediaUrl('product_image') }}"
                                                alt="Product" />
                                        @endif
                                    @endif
                                @endforeach
                            </div>

                            <div class="ec-pro-content">
                                <a href="single-product-left-sidebar.html"
                                    class="cart_pro_title">{{ $cartData->product_name }}</a>
                                <span class="cart-price">Rs. {{ $cartData->price }} x <span class ="qty-input"
                                        id="qty-input">{{ $cartData->quantity }} </span></span>
                                <div class="ec-pro-variation-inner ec-pro-variation-size">
                                    <span>SIZE: {{ $cartData->size }}</span>
                                </div>
                                <a href="{{ url('cart/delete/' . $cartData->cartid) }}" class="remove">×</a>
                            </div>
                        </li>
                    @empty
                        <img src="{{ url('assets/img/Empty-rafiki.png') }}" alt="Wishlist image"
                            class="img-fluid d-block mx-auto" style="max-width: 300px;" />
                    @endforelse

                </ul>
            </div>
            <div class="ec-cart-bottom">
                <div class="cart-sub-total">
                    <table class="table cart-table">
                        <tbody>
                            <tr>
                                <td class="text-left">Total :</td>
                                <td class="text-right primary-color total-price" id="total-price"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="cart_btn">
                    <a href="{{ url('cart') }}" class="btn btn-primary">View Cart</a>
                    <a href="{{ url('user/whole-checkout') }}" class="btn btn-secondary">Checkout</a>
                </div>
            </div>
        </div>
    @else
        <div class="ec-cart-inner">
            <div class="ec-cart-top">
                <div class="ec-cart-title">
                    <span class="cart_title">My Cart</span>
                    <button class="ec-close">×</button>
                </div>
                <h2 class="text-center m-5">Kindly proceed with logging in to access the wishlist.</h2>
            </div>
        </div>
    @endauth
</div>
<!-- Ekka Cart End -->
