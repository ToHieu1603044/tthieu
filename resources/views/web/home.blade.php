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
                                                <label>Size:</label>
                                                <div id="size_{{ $item->id }}" class="size-options">
                                                    @foreach ($variants[$item->id] as $sizeId => $sizeVariants)
                                                        @php
                                                            $size = $sizeVariants->first()->size;
                                                        @endphp
                                                        <label>
                                                            <input type="radio" name="size" class="size-radio"
                                                                data-product-id="{{ $item->id }}"
                                                                data-size-id="{{ $sizeId }}"
                                                                value="{{ $sizeId }}">
                                                            {{ $size->name }}
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Color:</label>
                                                <div id="color_{{ $item->id }}"  class="color-options">
                                                  
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
    document.addEventListener('DOMContentLoaded', function () {
    const variants = @json($variants);

    document.querySelectorAll('.size-radio').forEach(radio => {
        radio.addEventListener('change', function () {
            const productId = this.getAttribute('data-product-id');
            const sizeId = this.getAttribute('data-size-id');

            
            const colorContainer = document.querySelector(`#color_${productId}`);
            colorContainer.innerHTML = '';

            clearOtherSelections(productId);

            const sizeVariants = variants[productId][sizeId] || [];
            sizeVariants.forEach(variant => {
                const color = variant.color;

                const label = document.createElement('label');
                label.style.marginRight = '5px';

                const input = document.createElement('input');
                input.type = 'radio';
                input.name = `color`;
                input.value = color.id;
                input.setAttribute('data-stock', variant.stock);
                input.setAttribute('data-price', variant.price_sell);
                input.setAttribute('data-product-id', productId);

                label.appendChild(input);
                label.appendChild(document.createTextNode(color.name));
                colorContainer.appendChild(label);
            });

            updateStockPrice(productId, null);
        });
    });


document.addEventListener('change', function (event) {
    if (event.target.name === 'color') { 
        const productId = event.target.getAttribute('data-product-id');

        clearOtherSelections(productId);

        updateStockPrice(productId, event.target);
    }
});



    function updateStockPrice(productId, colorInput) {
        const stockElement = document.querySelector(`#stock_count_${productId}`);
        const priceElement = document.querySelector(`#price_${productId}`);

        if (colorInput) {
            const stock = colorInput.getAttribute('data-stock') || '0';
            const price = colorInput.getAttribute('data-price') || '0.00';

            stockElement.textContent = `${stock}`;
            priceElement.textContent = price;
        } else {
            stockElement.textContent = 'N/A';
            priceElement.textContent = '{{ $item->price_sell }}';
        }
    }


    function clearOtherSelections(currentProductId) {
  
    document.querySelectorAll('.size-radio, [name="color"]').forEach(input => {
        if (input.getAttribute('data-product-id') !== currentProductId) {
            input.checked = false;
        }
    });

    document.querySelectorAll(`[id^="stock_count_"], [id^="price_"]`).forEach(element => {
        const elementProductId = element.id.split('_')[2];
        if (elementProductId !== currentProductId) {
            if (element.id.startsWith('stock_count')) {
                element.textContent = 'N/A';
            } else if (element.id.startsWith('price')) {
                element.textContent = '{{ $item->price_sell }}';
            }
        }
    });
}

});

  </script>
   
@endsection
