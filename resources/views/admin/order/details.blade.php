@extends('main')

@section('content')
<div class="container">
    <article class="card">
        <header class="card-header"> My Orders / Tracking </header>
        <div class="card-body">
            <h6>Order ID: SPX{{$order->order_id}}</h6>
            <article class="card">
                <div class="card-body row">
                    <div class="col"> <strong>Estimated Delivery time:</strong> <br>{{ $order->time_order }}</div>
                    <div class="col"> <strong>Shipping BY:</strong> <br>  {{ $order->name }}, | <i class="fa fa-phone"></i>  {{ $order->phone }} </div>
                    <div class="col"> <strong>Status:</strong> <br>{{ $order->status}} </div>
                    <div class="col"> <strong>Tracking #:</strong> <br> 
                    @if ($order->note==0)
                        <span class="text-danger" >Chờ xác nhận</span>
                    @endif
                    </div>
                </div>
            </article>
            <div class="track">
                <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order confirmed</span> </div>
                <div class="step active"> <span class="icon"> <i class="fa fa-user"></i> </span> <span class="text"> Picked by courier</span> </div>
                <div class="step"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> On the way </span> </div>
                <div class="step"> <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text">Ready for pickup</span> </div>
            </div>
            <hr>
            <ul class="row">
                @foreach ($data as $item)
             
                <li class="col-md-4">
                    <figure class="itemside mb-3">
                        <div class="aside"><img width="100px" src="{{ Storage::url($item->product_image) }}" class="img-big border"></div>
                        <figcaption class="info align-self-center">
                            <p class="title">Tên sản phẩm: {{$item->product_name}}<br>Số lượng: {{$item->product_quantity}}</p> <span class="text-muted"> Tổng {{ $item->total_amount_per_product }} </span>
                        </figcaption>
                    </figure>
                </li>
                @endforeach
            </ul>
            <hr>
            <a href="{{ route('orders.index') }}" class="btn btn-warning" data-abc="true"> <i class="fa fa-chevron-left"></i> Back to orders</a>
        </div>
    </article>
</div>
@endsection