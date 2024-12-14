@extends('layout')
@include('web.navbar')

@section('content')

    <div class="container_fullwidth">
        <div class="container shopping-cart">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="title">
                       Giỏ hàng
                    </h3>
                    <div class="clearfix">
                    </div>
                    <table class="shop-table">
                        <thead>
                            <tr>
                                <th>
                                    Image
                                </th>
                                <th>
                                    Dtails
                                </th>
                                <th>
                                    Price
                                </th>
                                <th>
                                    Quantity
                                </th>
                                <th>
                                    Price
                                </th>
                                <th>
                                    Delete
                                </th>
                            </tr>
                        </thead>


                        <tbody>
                            @php
                                $total = 0;

                            @endphp
                            @if (session('cart'))
                                {{-- @dd(session('cart')) --}}
                                @foreach (session('cart') as $key => $item)
                                    @php
                                        $total += $item['price_sell'] * $item['quantity'];
                                    @endphp
                                    <tr>
                                        <td>
                                            <img src="{{ \Storage::url($item['image']) }}" alt="">
                                        </td>
                                        <td>
                                            <div class="shop-details">
                                                <div class="productname">
                                                    {{ $item['name'] }}
                                                </div>
                                                <p>
                                                    <img alt="" src="images/star.png">
                                                    <a class="review_num" href="#">
                                                        02 Review(s)
                                                    </a>
                                                </p>
                                                <div class="color-choser">
                                                    <span class="text">
                                                        Product Color :
                                                    </span>
                                                    <ul>

                                                        <li>
                                                            <a class="pink-bg" href="#">
                                                                {{ $item['color'] }}
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <p>
                                                    Product Code :
                                                    <strong class="pcode">
                                                        {{ $item['name'] }}TTH18964
                                                    </strong>
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <h5>
                                                {{ $item['price_sell'] }}.vnd
                                            </h5>
                                        </td>
                                        <td>
                                            Số lượng:
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" style="width: 75px;" min="1" max="{{$item['stock']}}"  >
                                        </td>
                                        <td>
                                            <h5>
                                                <strong class="red">
                                                    {{ $item['price_sell'] * $item['quantity'] }}.vnd
                                                </strong>
                                            </h5>
                                        </td>
                                        <td>
                                            <a class="pull-left btn btn-danger" href="{{route('removeCart',$key)}}">Xóa</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <h3 class="text-danger text-center pb-5 ">Giỏ hàng trống</h3>
                            @endif

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6">
                                    <button class="pull-left">
                                        <a href="/">Tiếp tục mua hàng</a>
                                    </button>
                                    <button class=" pull-right">
                                       Cập nhật giỏ hàng
                                    </button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="clearfix">
                    </div>
                    <div class="row">
                       
                        <div class="col-md-4 col-sm-6">
                            <div class="shippingbox">
                                <h5>
                                   Mã giản giá
                                </h5>
                                <form>
                                    <label>
                                        Enter your coupon code if you have one
                                    </label>
                                    <input type="text" name="">
                                    <div class="clearfix">
                                    </div>
                                    <button>
                                        Xác nhận
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="shippingbox">
                                <div class="subtotal">
                                    <h5>
                                        Tổng tiền
                                    </h5>
                                    <span>
                                        {{ $total }}.vnd
                                    </span>
                                </div>
                                <div class="grandtotal">
                                    <h5>
                                        Số tiền cần thanh toán
                                    </h5>
                                    <span>
                                        {{ $total }}.VND
                                    </span>
                                </div>
                                <a href="{{ route('checkout') }}" class="btn btn-success" >Thanh toán</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix">
            </div>

        </div>
    </div>
@endsection
