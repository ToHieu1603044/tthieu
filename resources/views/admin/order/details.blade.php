@extends('main')

@section('content')
    <div class="container">
        <style>
            .track {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 20px;
                position: relative;
            }

            .step {
                text-align: center;
                flex: 1;
                position: relative;
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 20px 0;
            }

            .step .icon {
                font-size: 24px;
                color: #bbb;
                transition: color 0.3s ease;
                margin-bottom: 15px;
            }

            .step .text {
                font-size: 14px;
                color: #bbb;
                font-weight: 600;
                text-transform: uppercase;
            }

            .step.active .icon {
                color: #4caf50;

            }

            .step.active .text {
                color: #4caf50;

            }


            .track:before {
                display: none;
            }

            .step:hover .icon {
                color: #4caf50;
                cursor: pointer;
            }

            .step.active .icon {
                color: #4caf50;
                /* Green color when active */
            }

            .step.active .text {
                color: #4caf50;
                /* Green color for text when active */
            }
        </style>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <article class="card shadow-sm">
            <header class="card-header bg-primary text-white"> Đơn hàng / Chi tiết </header>
            <div class="card-body">
                <h6><strong>Order ID:</strong> SPX{{ $order->order_id }}</h6>

                <!-- Order Details -->
                <article class="card mt-3">
                    <div class="card-body row">
                        <div class="col-md-3"> <strong>Estimated Delivery Time:</strong> <br>{{ $order->time_order }}</div>
                        <div class="col-md-3"> <strong>Shipping By:</strong> <br>{{ $order->name }}, | <i
                                class="fa fa-phone"></i> {{ $order->phone }}</div>
                        <div class="col-md-3"> <strong>Status:</strong> <br>{{ $order->status }}</div>
                        <div class="col-md-3"> <strong>Tracking #:</strong> <br>
                            @if ($order->note == 0)
                                <span class="text-danger">Chờ xác nhận</span>
                            @elseif ($order->note == 1)
                                <span class="text-danger">Đã xác nhận</span>
                            @elseif ($order->note == 2)
                                <span class="text-danger">Đã gửi hàng</span>
                            @elseif ($order->note == 3)
                                <span class="text-danger">Đang giao</span>
                            @elseif ($order->note == 4)
                                <span class="text-danger">Đã nhận</span>
                            @endif
                        </div>
                    </div>
                </article>


                <div class="track mt-4">
                    <!-- Step 0: Chờ xác nhận -->
                    <div class="step @if ($order->note >= 0) active @endif" data-note="0">
                        <span class="icon"><i class="fa-solid fa-circle-exclamation"></i></span>
                        <span class="text">Chờ xác nhận</span>
                    </div>


                    <div class="step @if ($order->note >= 1) active @endif" data-note="1">
                        <span class="icon"><i class="fa fa-check"></i></span>
                        <span class="text">Đã xác nhận</span>
                    </div>


                    <div class="step @if ($order->note >= 2) active @endif"data-note="2">
                        <span class="icon"><i class="fa fa-user"></i></span>
                        <span class="text">Đã gửi hàng</span>
                    </div>

                    <div class="step @if ($order->note >= 3) active @endif" data-note="3">
                        <span class="icon"><i class="fa fa-truck"></i></span>
                        <span class="text">Đang giao</span>
                    </div>


                    <div class="step @if ($order->note >= 4) active @endif">
                        <span class="icon"><i class="fa fa-box"></i></span>
                        <span class="text">Đã nhận hàng</span>
                    </div>
                </div>
                <hr>

                <h5>Ordered Items</h5>
                <ul class="row">
                    @foreach ($data as $item)
                        <li class="col-md-4">
                            <figure class="itemside mb-3">
                                <div class="aside"><img width="100px" src="{{ Storage::url($item->product_image) }}"
                                        class="img-fluid border"></div>
                                <figcaption class="info align-self-center">
                                    <p class="title">Product Name: {{ $item->product_name }}<br>Quantity:
                                        {{ $item->product_quantity }}</p>
                                    <span class="text-muted">Total: {{ number_format($item->total_amount_per_product, 2) }}
                                        VND</span>
                                </figcaption>
                            </figure>
                        </li>
                    @endforeach
                </ul>

                <hr>
                <a href="{{ route('orders.index') }}" class="btn btn-warning" data-abc="true">
                    <i class="fa fa-chevron-left"></i> Trở lại
                </a>
                <a href="{{ route('orders.index') }}" class="btn btn-success" data-abc="true">
                    Cập nhật
                </a>
            </div>
        </article>
    </div>

    <script>
    
        document.addEventListener('DOMContentLoaded', function() {
            const steps = document.querySelectorAll('.step');

            steps.forEach(function(step) {
                step.addEventListener('click', function() {

                    let noteValue = step.getAttribute('data-note');

                    step.classList.toggle('active');

                    updateOrderNote(noteValue);
                });
            });
        });

        function updateOrderNote(noteValue) {

            fetch("{{ route('order.updateNote', ['id' => $order->order_id]) }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        note: noteValue
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Order note updated successfully');
                    } else {
                        console.log('Failed to update order note:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
@endsection
