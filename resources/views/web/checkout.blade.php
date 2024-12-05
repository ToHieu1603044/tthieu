@extends('layout')

@section('content')


<div class="container_fullwidth">
    <div class="container">
        <div class="row">
            <!-- Sidebar Left: Special Deals -->
            <div class="col-md-3">
                <div class="special-deal leftbar">
                    <h4 class="title">Special <strong>Deals</strong></h4>
                    @if (session('cart'))
                        @foreach (session('cart') as $item)
                            <div class="special-item">
                                <div class="product-image">
                                    <a href="details.html">
                                        <img src="{{ \Storage::url($item['image']) }}" alt="">
                                    </a>
                                </div>
                                <div class="product-info">
                                    <p><a href="details.html">{{ $item['name'] }}</a></p>
                                    <h5 class="price">{{ $item['price_sell'] }}</h5>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>Chưa có sản phẩm</p>
                    @endif
                </div>

                <!-- Sidebar Left: Newsletter -->
                <div class="get-newsletter leftbar">
                    <h3 class="title">Get <strong>Newsletter</strong></h3>
                    <p>Casio G Shock Digital Dial Black.</p>
                    <form>
                        <input class="email" type="email" placeholder="Your Email...">
                        <input class="submit" type="submit" value="Submit">
                    </form>
                </div>
            </div>

            <!-- Main Checkout Section -->
            <div class="col-md-9">
                <div class="checkout-page">
                    <ol class="checkout-steps">
                        <li class="steps active">
                            <a href="checkout.html" class="step-title">Thông tin giao hàng</a>
                            <div class="step-description">
                                <form action="{{ route('check') }}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="total_amount" value="{{ $totalAmount }}">
                                    <input type="hidden" name="cart_items" value="{{ json_encode(session('cart')) }}">

                                    <div class="row">
                                        <!-- Personal Details -->
                                        <div class="col-md-6 col-sm-6">
                                            <div class="your-details">
                                                <h5>Thông tin</h5>
                                                <div class="form-row">
                                                    <label>Họ Tên <strong class="red">*</strong></label>
                                                    <input type="text" class="input namefield" name="name" required>
                                                </div>
                                                <div class="form-row">
                                                    <label>Email <strong class="red">*</strong></label>
                                                    <input type="email" class="input namefield" name="email" required>
                                                </div>
                                                <div class="form-row">
                                                    <label>Điện thoại <strong class="red">*</strong></label>
                                                    <input type="text" class="input namefield" name="phone" required>
                                                </div>

                                                <!-- Payment Method Section -->
                                                <div class="form-row">
                                                    <label>Phương thức thanh toán <strong class="red">*</strong></label>
                                                    <div>
                                                        <input type="radio" id="paymentOffline" name="payment_method"
                                                            value="offline" checked>
                                                        <label for="paymentOffline">Thanh toán khi nhận hàng</label>
                                                    </div>
                                                    <div>
                                                        <input type="radio" id="paymentOnline" name="payment_method"
                                                            value="online">
                                                        <label for="paymentOnline">Thanh toán online</label>
                                                    </div>
                                                </div>

                                                <div id="onlinePaymentOptions" style="display: none;">
                                                    <div class="form-row">
                                                        <label>Chọn phương thức thanh toán</label>
                                                        <select class="form-select w-100" name="payment_method_option">
                                                            <option value="momo">Momo</option>
                                                            <option value="vnpay">VNPay</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <br>
                                                <p>
                                                    <span class="input-radio">
                                                        <input type="radio" required>
                                                    </span>
                                                    <span class="text">Tôi chấp nhận với <a href="">điều khoản</a></span>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Shipping Address -->
                                        <div class="col-md-6 col-sm-6">
                                            <div class="your-details">
                                                <h5>Địa chỉ giao hàng</h5>
                                                <div class="form-row">
                                                    <label>Xã <strong class="red">*</strong></label>
                                                    <input type="text" class="input namefield" name="ward" required>
                                                </div>
                                                <div class="form-row">
                                                    <label>Huyện <strong class="red">*</strong></label>
                                                    <input type="text" class="input namefield" name="district" required>
                                                </div>
                                                <div class="form-row">
                                                    <label>Tỉnh/Thành Phố <strong class="red">*</strong></label>
                                                    <input type="text" class="input namefield" name="city" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit">Thanh toán</button>
                                </form>
                            </div>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
        document.querySelectorAll('input[name="payment_method"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                var onlinePaymentOptions = document.getElementById('onlinePaymentOptions');
                if (document.getElementById('paymentOnline').checked) {
                    onlinePaymentOptions.style.display = 'block';
                } else {
                    onlinePaymentOptions.style.display = 'none';
                }
            });
        });

        document.querySelectorAll('input[name="payment_method"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            var onlinePaymentOptions = document.getElementById('onlinePaymentOptions');
            if (document.getElementById('paymentOnline').checked) {
                onlinePaymentOptions.style.display = 'block';
            } else {
                onlinePaymentOptions.style.display = 'none';
            }
        });
    });

    window.addEventListener('DOMContentLoaded', (event) => {
        var successAlert = document.getElementById('successAlert');
        if (successAlert) {
            setTimeout(function() {
                successAlert.style.display = 'none';
            }, 5000); // 5 seconds
        }
    });

</script>
@endsection
