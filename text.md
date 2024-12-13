@foreach ($variants as $colorId => $colorVariants)
    <div>
 
       

        @php
           
            $color = $colorVariants->first()->color;
        
        @endphp
          
        <h4>Color: {{ $color->name }}</h4> <!-- Assuming 'name' is the color name -->

        @foreach ($colorVariants as $variant)
            <div>
                <span>Size: {{ $variant->size->name }}</span> <!-- Assuming 'name' is the size name -->
                <span>Stock: {{ $variant->stock }}</span>
                <span>Price: {{ $variant->price_sell }}</span>
            </div>
        @endforeach
    </div>
@endforeach