@extends('layout')
@include('web.navbar')
@include('web.slider')

@section('content')
    <div class="container_fullwidth">
        <div class="container">
            <div class="hot-products">
                <h3 class="title"><strong>Hot</strong> Products</h3>
                <div class="control">
                    <a id="prev_hot" class="prev" href="#">&lt;</a>
                    <a id="next_hot" class="next" href="#">&gt;</a>
                </div>
                <ul id="hot">
                    <li>
                        <div class="row">
                            @foreach ($product as $item)
                               <form action="{{ route('cart',$item->id) }}" method="post" enctype="multipart/form-data" >
                                @csrf
                                <div class="col-md-3 col-sm-6">
                                    <div class="products">
                                        <div class="offer">- %20</div>
                                        <div class="thumbnail">
                                            <a href="{{ route('product.detail', $item->id) }}">
                                                <img width="200px" src="{{ \Storage::url($item['img']) }}"
                                                    alt="{{ $item->name }}">
                                            </a>
                                        </div>
                                        <div class="productname">
                                            <a href="{{ route('product.detail', $item->id) }}">{{ $item['name'] }}</a>
                                        </div>
                                        <h4 class="price">{{ $item['price_sell'] }}</h4>

                                        <!-- Chọn màu -->
                                        <div class="form-group">
                                            <label>Color:</label>
                                            <div id="color_{{ $item->id }}" class="color-options">
                                                @foreach ($variants[$item->id] as $colorId => $colorVariants)
                                                    @php
                                                        $color = $colorVariants->first()->color;
                                                    @endphp
                                                    <label>
                                                        <input type="checkbox" name="color"
                                                            class="color-checkbox"
                                                            data-product-id="{{ $item->id }}"
                                                            data-color-id="{{ $colorId }}"
                                                            value="{{ $colorId }}">
                                                        <img src=""
                                                            alt="{{ $color->name }}"
                                                            style="width: 24px; height: 24px; border: 1px solid #ddd; border-radius: 50%;">
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Chọn kích thước -->
                                        <div class="form-group">
                                            <label>Size:</label>
                                            <div id="size_{{ $item->id }}" class="size-options" >
                                                <!-- Kích thước sẽ được thêm động -->
                                            </div>
                                        </div>

                                        <!-- Stock information -->
                                        {{-- <div id="stock_{{ $item->id }}">
                                            <p>In Stock: <span id="stock_count_{{ $item->id }}">0</span></p>
                                           
                                        </div> --}}

                                        <!-- Nút thêm vào giỏ -->
                                        <div class="button_group">
                                            <button type="submit"  class="button add-cart" >Add Cart</button>
                                            <button class="button compare" type="button"><i
                                                    class="fa fa-exchange"></i></button>
                                            <button class="button wishlist" type="button"><i
                                                    class="fa fa-heart-o"></i></button>
                                        </div>
                                    </div>
                                </div>
                               </form>
                            @endforeach
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Thêm JavaScript -->
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const variants = @json($variants);

    // Lắng nghe sự kiện khi chọn màu
    document.querySelectorAll('.color-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const productId = this.getAttribute('data-product-id');
            const colorId = this.getAttribute('data-color-id');

            // Reset các checkbox kích thước của các sản phẩm khác
            document.querySelectorAll(`.size-options`).forEach(sizeContainer => {
                sizeContainer.innerHTML = '';  // Xóa kích thước đã chọn trước đó
            });

            // Lấy container cho kích thước của sản phẩm hiện tại
            const sizeContainer = document.querySelector(`#size_${productId}`);
            const colorVariants = variants[productId][colorId];

            // Xóa các kích thước cũ và thêm các kích thước mới
            sizeContainer.innerHTML = '';
            colorVariants.forEach(variant => {
                const label = document.createElement('label');
                label.style.marginRight = '5px';

                const input = document.createElement('input');
                input.type = 'radio';
                input.name = `size`; 
                input.value = variant.size.id;

                label.appendChild(input);
                label.appendChild(document.createTextNode(variant.size.name));

                sizeContainer.appendChild(label);
            });

            // Nếu màu được chọn, cần phải bỏ chọn các màu ở sản phẩm khác
            document.querySelectorAll('.color-checkbox').forEach(otherCheckbox => {
                if (otherCheckbox !== this) {
                    otherCheckbox.checked = false;  // Bỏ chọn các checkbox màu khác
                }
            });

            // Cập nhật lại thông tin stock và price nếu đã chọn màu
            updateStockPrice(productId, colorId);
        });
    });

    // Lắng nghe sự kiện khi chọn kích thước (với radio button)
    document.querySelectorAll('.size-options input').forEach(input => {
        input.addEventListener('change', function () {
            const productId = this.name.split('_')[1]; // Lấy productId từ tên của input radio button
            const sizeId = this.value;
            const colorId = document.querySelector(`#color_${productId} input:checked`)?.value;

            if (colorId && sizeId) {
                // Lấy số lượng cho màu và kích thước đã chọn
                updateStockPrice(productId, colorId, sizeId);
            }
        });
    });

  
});




    </script>
@endsection
