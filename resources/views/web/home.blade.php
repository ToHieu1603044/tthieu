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
                                <form action="{{ route('cart', $item->id) }}" method="post" enctype="multipart/form-data">
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
                                            <p id="price_{{ $item->id }}" class="price">{{ $item['price_sell'] }}</p>


                                            <div class="form-group">
                                                <label>Color:</label>
                                                <div id="color_{{ $item->id }}" class="color-options">
                                                    @foreach ($variants[$item->id] as $colorId => $colorVariants)
                                                        @php
                                                            $color = $colorVariants->first()->color;
                                                        @endphp
                                                        <label>
                                                            <input type="checkbox" name="color" class="color-checkbox"
                                                                data-product-id="{{ $item->id }}"
                                                                data-color-id="{{ $colorId }}"
                                                                value="{{ $colorId }}">
                                                            <img src="" alt="{{ $color->name }}"
                                                                style="width: 24px; height: 24px; border: 1px solid #ddd; border-radius: 50%;">
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <input type="hidden" name="quantity" value="1">

                                            <div class="form-group">
                                                <label>Size:</label>
                                                <div id="size_{{ $item->id }}" class="size-options">

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Stock:</label>
                                                <p id="stock_count_{{ $item->id }}">N/A</p>
                                            </div>

                                            <div class="button_group">
                                                <button type="submit" class="button add-cart">Add Cart</button>
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


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const variants = @json($variants);


            document.querySelectorAll('.color-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const productId = this.getAttribute('data-product-id');
                    const colorId = this.getAttribute('data-color-id');


                    document.querySelectorAll('.color-checkbox').forEach(otherCheckbox => {
                        if (otherCheckbox !== this) {
                            otherCheckbox.checked = false;
                        }
                    });

                    const sizeContainer = document.querySelector(`#size_${productId}`);
                    sizeContainer.innerHTML = '';

                    const colorVariants = variants[productId][colorId] || [];
                    if (colorVariants.length > 0) {
                        colorVariants.forEach(variant => {
                            const label = document.createElement('label');
                            label.style.marginRight = '5px';

                            const input = document.createElement('input');
                            input.type = 'radio';
                            input.name = `size`;
                            input.value = variant.size.id;
                            input.setAttribute('data-stock', variant.stock);
                            input.setAttribute('data-price', variant.price_sell);
                            input.setAttribute('data-product-id', productId);

                            label.appendChild(input);
                            label.appendChild(document.createTextNode(variant.size.name));

                            sizeContainer.appendChild(label);
                        });
                    }

                    updateStockPrice(productId, null, null);
                });
            });

            document.addEventListener('change', function(event) {
                if (event.target.name === 'size') {
                    const productId = event.target.getAttribute('data-product-id');
                    const sizeId = event.target.value;
                    const colorId = document.querySelector(`#color_${productId} input:checked`)?.value;

                    if (colorId && sizeId) {
                        updateStockPrice(productId, colorId, sizeId);
                    }
                }
            });

            function updateStockPrice(productId, colorId, sizeId) {
                const stockElement = document.querySelector(`#stock_count_${productId}`);
                const priceElement = document.querySelector(`#price_${productId}`);

                if (colorId && sizeId) {
                    const sizeInput = document.querySelector(`input[name="size"][value="${sizeId}"]`);
                    const stock = sizeInput?.getAttribute('data-stock') || '0';
                    const price = sizeInput?.getAttribute('data-price') || '0.00';

                    stockElement.textContent = stock + ' items in stock';
                    priceElement.textContent = price;
                } else {
                    stockElement.textContent = 'N/A';
                    priceElement.textContent = '{{ $item->price_sell }}';
                }
            }
        });
    </script>
@endsection
