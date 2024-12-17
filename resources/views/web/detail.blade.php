@extends('layout')
@include('web.navbar')
@section('content')
    <div class="container_fullwidth">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="products-details">
                        <div class="preview_image">
                            <div class="preview-small">
                                <img id="zoom_03" src="images/products/medium/products-01.jpg"
                                    data-zoom-image="images/products/Large/products-01.jpg" alt="">
                            </div>
                            <div class="thum-image">
                                <ul id="gallery_01" class="prev-thum">
                                    <li>
                                        <a href="#" data-image="images/products/medium/products-01.jpg"
                                            data-zoom-image="images/products/Large/products-01.jpg">
                                            <img src="images/products/thum/products-01.png" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" data-image="images/products/medium/products-02.jpg"
                                            data-zoom-image="images/products/Large/products-02.jpg">
                                            <img src="images/products/thum/products-02.png" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" data-image="images/products/medium/products-03.jpg"
                                            data-zoom-image="images/products/Large/products-03.jpg">
                                            <img src="images/products/thum/products-03.png" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" data-image="images/products/medium/products-04.jpg"
                                            data-zoom-image="images/products/Large/products-04.jpg">
                                            <img src="images/products/thum/products-04.png" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" data-image="images/products/medium/products-05.jpg"
                                            data-zoom-image="images/products/Large/products-05.jpg">
                                            <img src="images/products/thum/products-05.png" alt="">
                                        </a>
                                    </li>
                                </ul>
                                <a class="control-left" id="thum-prev" href="javascript:void(0);">
                                    <i class="fa fa-chevron-left">
                                    </i>
                                </a>
                                <a class="control-right" id="thum-next" href="javascript:void(0);">
                                    <i class="fa fa-chevron-right">
                                    </i>
                                </a>
                            </div>
                        </div>
                        <form action="{{ route('cart', $product->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="products-description">
                                <h5 class="name">{{ $product->name }}</h5>
                                <p>
                                    <img width="200px" alt="" src="{{ \Storage::url($product->img) }}">
                                    <a class="review_num" href="#">02 Review(s)</a>
                                </p>

                                <p>
                                    Availability:
                                    <span class="light-red">
                                        @if ($product->status == 1)
                                            Còn Hàng
                                        @else
                                            Hết Hàng
                                        @endif
                                    </span>
                                </p>

                                <p>{{ $product->description }}</p>

                                <hr class="border">
                                <div class="price">
                                    {{-- Price: <span  id="price" class="new_price"  >{{ $product->price_sell }}</span> --}}
                                    {{-- <input type="text" name="price" value=" {{ $product->price_sell }}" id="price"
                                        class="price"> --}}
                                    {{-- <span id="price" class="old_price">{{ $product->price_sell }} <sup>Vnd</sup></span> --}}
                                </div>
                                <div class="form-group">
                                    <label for="price" >Price:</label>
                                    <h4 style="color: red" id="price">N/A</h4>
                                </div>

                                <hr class="border">

                                <div class="wided">

                                    <div class="form-group">
                                        <label for="sizeSelection">Size:</label>
                                        <select class="form-select" id="sizeSelection" name="size">
                                            <option value="">Select Size</option>
                                            @foreach ($variants as $sizeId => $sizeVariants)
                                                @php
                                                    $size = $sizeVariants->first()->size; // Lấy thông tin size từ bản ghi đầu tiên
                                                @endphp
                                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="colorSelection">Color:</label>
                                        <select class="form-select" id="colorSelection" name="color">
                                            <option value="">Select Color</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="stock">Stock:</label>
                                        <p id="stock">N/A</p>
                                    </div>
                                    
                                    <p>Price: <span id="price">N/A</span></p>
                                    
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const sizeSelection = document.getElementById('sizeSelection');
                                            const colorSelection = document.getElementById('colorSelection');
                                            const stockDisplay = document.getElementById('stock');
                                            const priceDisplay = document.getElementById('price');
                                    
                                            // Dữ liệu biến thể từ server (đã nhóm theo size_id)
                                            const variants = @json($variants);
                                    
                                            // Khi chọn size
                                            sizeSelection.addEventListener('change', function() {
                                                const sizeId = sizeSelection.value;
                                    
                                                // Reset dropdown màu và thông tin stock/price
                                                colorSelection.innerHTML = '<option value="">Select Color</option>';
                                                stockDisplay.textContent = 'N/A';
                                                priceDisplay.textContent = 'N/A';
                                    
                                                if (sizeId && variants[sizeId]) {
                                                    const sizeVariants = variants[sizeId];
                                    
                                                    // Thêm các màu sắc tương ứng với size đã chọn
                                                    sizeVariants.forEach(variant => {
                                                        const colorOption = document.createElement('option');
                                                        colorOption.value = variant.color.id;
                                                        colorOption.textContent = variant.color.name;
                                                        colorOption.dataset.stock = variant.stock;
                                                        colorOption.dataset.price = variant.price_sell;
                                    
                                                        colorSelection.appendChild(colorOption);
                                                    });
                                                }
                                            });
                                    
                                            // Khi chọn màu
                                            colorSelection.addEventListener('change', function() {
                                                const selectedOption = colorSelection.options[colorSelection.selectedIndex];
                                    
                                                if (selectedOption && selectedOption.value) {
                                                    // Lấy thông tin stock và price từ dataset
                                                    const stock = selectedOption.dataset.stock;
                                                    const price = selectedOption.dataset.price;
                                    
                                                    stockDisplay.textContent = `${stock} items in stock`;
                                                    priceDisplay.textContent = `$${price}`;
                                                } else {
                                                    stockDisplay.textContent = 'N/A';
                                                    priceDisplay.textContent = 'N/A';
                                                }
                                            });
                                        });
                                    </script>
                                    

                                    <!-- Phần chọn số lượng -->
                                    <div class="qty">
                                        Qty &nbsp;&nbsp;:
                                        <select class="form-select" name="quantity">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    </div>

                                    <div class="button_group">
                                        <button class="button" type="submit">Add To Cart</button>
                                        <button class="button compare">
                                            <i class="fa fa-exchange"></i>
                                        </button>
                                        <button class="button favorite">
                                            <i class="fa fa-heart-o"></i>
                                        </button>
                                        <button class="button favorite">
                                            <i class="fa fa-envelope-o"></i>
                                        </button>
                                    </div>
                                </div>
                        </form>
                    </div>
                    <div class="clearfix">
                    </div>
                    <div class="tab-box">
                        <div id="tabnav">
                            <ul>
                                <li>
                                    <a href="#Descraption">
                                        DESCRIPTION
                                    </a>
                                </li>
                                <li>
                                    <a href="#Reviews">
                                        REVIEW
                                    </a>
                                </li>
                                <li>
                                    <a href="#tags">
                                        PRODUCT TAGS
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content-wrap">
                            <div class="tab-content" id="Descraption">

                                <p>
                                    {{ $product->descriptions }}
                                </p>
                            </div>
                            <div class="tab-content" id="Reviews">
                                <form>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>
                                                    &nbsp;
                                                </th>
                                                <th>
                                                    1 star
                                                </th>
                                                <th>
                                                    2 stars
                                                </th>
                                                <th>
                                                    3 stars
                                                </th>
                                                <th>
                                                    4 stars
                                                </th>
                                                <th>
                                                    5 stars
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    Quality
                                                </td>
                                                <td>
                                                    <input type="radio" name="quality" value="Blue" />
                                                </td>
                                                <td>
                                                    <input type="radio" name="quality" value="">
                                                </td>
                                                <td>
                                                    <input type="radio" name="quality" value="">
                                                </td>
                                                <td>
                                                    <input type="radio" name="quality" value="">
                                                </td>
                                                <td>
                                                    <input type="radio" name="quality" value="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Price
                                                </td>
                                                <td>
                                                    <input type="radio" name="price" value="">
                                                </td>
                                                <td>
                                                    <input type="radio" name="price" value="">
                                                </td>
                                                <td>
                                                    <input type="radio" name="price" value="">
                                                </td>
                                                <td>
                                                    <input type="radio" name="price" value="">
                                                </td>
                                                <td>
                                                    <input type="radio" name="price" value="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Value
                                                </td>
                                                <td>
                                                    <input type="radio" name="value" value="">
                                                </td>
                                                <td>
                                                    <input type="radio" name="value" value="">
                                                </td>
                                                <td>
                                                    <input type="radio" name="value" value="">
                                                </td>
                                                <td>
                                                    <input type="radio" name="value" value="">
                                                </td>
                                                <td>
                                                    <input type="radio" name="value" value="">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-row">
                                                <label class="lebel-abs">
                                                    Your Name
                                                    <strong class="red">
                                                        *
                                                    </strong>
                                                </label>
                                                <input type="text" name="" class="input namefild">
                                            </div>
                                            <div class="form-row">
                                                <label class="lebel-abs">
                                                    Your Email
                                                    <strong class="red">
                                                        *
                                                    </strong>
                                                </label>
                                                <input type="email" name="" class="input emailfild">
                                            </div>
                                            <div class="form-row">
                                                <label class="lebel-abs">
                                                    Summary of You Review
                                                    <strong class="red">
                                                        *
                                                    </strong>
                                                </label>
                                                <input type="text" name="" class="input summeryfild">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-row">
                                                <label class="lebel-abs">
                                                    Your Name
                                                    <strong class="red">
                                                        *
                                                    </strong>
                                                </label>
                                                <textarea class="input textareafild" name="" rows="7">
                        </textarea>
                                            </div>
                                            <div class="form-row">
                                                <input type="submit" value="Submit" class="button">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-content">
                                <div class="review">
                                    <p class="rating">
                                        <i class="fa fa-star light-red">
                                        </i>
                                        <i class="fa fa-star light-red">
                                        </i>
                                        <i class="fa fa-star light-red">
                                        </i>
                                        <i class="fa fa-star-half-o gray">
                                        </i>
                                        <i class="fa fa-star-o gray">
                                        </i>
                                    </p>
                                    <h5 class="reviewer">
                                        Reviewer name
                                    </h5>
                                    <p class="review-date">
                                        Date: 01-01-2014
                                    </p>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer a eros neque. In
                                        sapien est, malesuada non interdum id, cursus vel neque.
                                    </p>
                                </div>
                                <div class="review">
                                    <p class="rating">
                                        <i class="fa fa-star light-red">
                                        </i>
                                        <i class="fa fa-star light-red">
                                        </i>
                                        <i class="fa fa-star light-red">
                                        </i>
                                        <i class="fa fa-star-half-o gray">
                                        </i>
                                        <i class="fa fa-star-o gray">
                                        </i>
                                    </p>
                                    <h5 class="reviewer">
                                        Reviewer name
                                    </h5>
                                    <p class="review-date">
                                        Date: 01-01-2014
                                    </p>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer a eros neque. In
                                        sapien est, malesuada non interdum id, cursus vel neque.
                                    </p>
                                </div>
                            </div>
                            <div class="tab-content" id="tags">
                                <div class="tag">
                                    Add Tags :
                                    <input type="text" name="">
                                    <input type="submit" value="Tag">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix">
                    </div>

                    <div class="clearfix">
                    </div>
                </div>
                <div class="col-md-3">

                    <div class="clearfix">
                    </div>
                    <div class="product-tag leftbar">
                        <h3 class="title">
                            Products
                            <strong>
                                Tags
                            </strong>
                        </h3>
                        <ul>
                            <li>
                                <a href="#">
                                    Lincoln us
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    SDress for Girl
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Corner
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Window
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    PG
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Oscar
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Bath room
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    PSD
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="clearfix">
                    </div>
                    <div class="get-newsletter leftbar">
                        <h3 class="title">
                            Get
                            <strong>
                                newsletter
                            </strong>
                        </h3>
                        <p>
                            Casio G Shock Digital Dial Black.
                        </p>
                        <form>
                            <input class="email" type="text" name="" placeholder="Your Email...">
                            <input class="submit" type="submit" value="Submit">
                        </form>
                    </div>
                    <div class="clearfix">
                    </div>
                    <div class="fbl-box leftbar">
                        <h3 class="title">
                            Facebook
                        </h3>
                        <span class="likebutton">
                            <a href="#">
                                <img src="images/fblike.png" alt="">
                            </a>
                        </span>
                        <p>
                            12k people like Flat Shop.
                        </p>
                        <ul>
                            <li>
                                <a href="#">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                </a>
                            </li>
                        </ul>
                        <div class="fbplug">
                            <a href="#">
                                <span>
                                    <img src="images/fbicon.png" alt="">
                                </span>
                                Facebook social plugin
                            </a>
                        </div>
                    </div>
                    <div class="clearfix">
                    </div>
                </div>
            </div>
            <div class="clearfix">
            </div>
            <div class="our-brand">
                <h3 class="title">
                    <strong>
                        Our
                    </strong>
                    Brands
                </h3>
                <div class="control">
                    <a id="prev_brand" class="prev" href="#">
                        &lt;
                    </a>
                    <a id="next_brand" class="next" href="#">
                        &gt;
                    </a>
                </div>
                <ul id="braldLogo">
                    <li>
                        <ul class="brand_item">
                            <li>
                                <a href="#">
                                    <div class="brand-logo">
                                        <img src="images/envato.png" alt="">
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="brand-logo">
                                        <img src="images/themeforest.png" alt="">
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="brand-logo">
                                        <img src="images/photodune.png" alt="">
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="brand-logo">
                                        <img src="images/activeden.png" alt="">
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="brand-logo">
                                        <img src="images/envato.png" alt="">
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul class="brand_item">
                            <li>
                                <a href="#">
                                    <div class="brand-logo">
                                        <img src="images/envato.png" alt="">
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="brand-logo">
                                        <img src="images/themeforest.png" alt="">
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="brand-logo">
                                        <img src="images/photodune.png" alt="">
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="brand-logo">
                                        <img src="images/activeden.png" alt="">
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="brand-logo">
                                        <img src="images/envato.png" alt="">
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
