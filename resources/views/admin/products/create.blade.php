@extends('main')

@section('content')
    <div class="container">
        <div aria-live="polite" aria-atomic="true" class="position-relative">
            <div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer">
                @foreach ($errors->all() as $error)
                    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <strong class="me-auto text-danger">Lỗi</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            {{ $error }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

            <header class="card-header bg-primary text-white mb-5">Sản phẩm / Sửa sản phẩm</header>
            <ul class="nav nav-tabs" id="productTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="product-details-tab" data-bs-toggle="tab" href="#product-details"
                        role="tab" aria-controls="product-details" aria-selected="true">Chi Tiết Sản Phẩm</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="product-variants-tab" data-bs-toggle="tab" href="#product-variants"
                        role="tab" aria-controls="product-variants" aria-selected="false">Biến Thể Sản Phẩm</a>
                </li>
            </ul>
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="tab-content mt-3" id="productTabContent">
                    <!-- Tab 1: Chi Tiết Sản Phẩm -->
                    <div class="tab-pane fade show active" id="product-details" role="tabpanel"
                        aria-labelledby="product-details-tab">
                        <div class="mb-3">
                            <label for="productName" class="form-label">Tên Sản Phẩm</label>
                            <input type="text" class="form-control" id="productName" name="name"
                                value="{{ old('name') }}">
                        </div>

                        <div class="mb-3">
                            <label for="productName" class="form-label">Ảnh</label>
                            <input type="file" class="form-control" id="img" name="img"
                                value="{{ old('img') }}">
                        </div>

                        <div class="mb-3">
                            <label for="productPrice" class="form-label">Giá Gốc</label>
                            <input type="number" class="form-control" id="productPrice" name="price_buy"
                                value="{{ old('price_buy') }}">
                        </div>
                        <div class="mb-3">
                            <label for="productPrice" class="form-label">Giá Bán</label>
                            <input type="number" class="form-control" id="productPrice" name="price_sell"
                                value="{{ old('price_sell') }}">
                        </div>
                        <div class="mb-3">
                            <label for="parentCategory" class="form-label">Thời Trang</label>
                            <select class="form-select" id="parentCategory" name="parent_id">
                                <option value="">--------------</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('parent_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Danh mục</label>
                            <select class="form-select" id="category" name="category_id">
                                <option value="">--------------</option>
                                @foreach ($categories as $category)
                                    @foreach ($category->children as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('category_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="productDescription" class="form-label">Mô Tả Ngắn</label>
                            <textarea class="form-control" id="productDescription" name="description" rows="4">{{ old('description') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="productFullDescription" class="form-label">Mô Tả Chi Tiết</label>
                            <textarea class="form-control" id="productFullDescription" name="descriptions" rows="4">{{ old('descriptions') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="productStatus" class="form-label">Trạng Thái</label>
                            <select class="form-select" id="productStatus" name="status">
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Còn Hàng</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Hết Hàng</option>
                            </select>
                        </div>
                    </div>

 
                    <div class="tab-pane fade" id="product-variants" role="tabpanel" aria-labelledby="product-variants-tab">
                        <div class="mb-3">
                            <label class="form-label">Chọn Màu Sắc</label>
                            @foreach ($colors as $key => $value)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $key }}" name="color[]" id="color{{ $key }}"
                                        {{ in_array($key, old('color', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="color{{ $key }}">{{ $value }}</label>
                                    
                                    <!-- Chi tiết biến thể cho mỗi màu -->
                                    <div class="mt-3 ms-4">
                                        @foreach ($sizes as $sizeKey => $sizeValue)
                                            <div class="mb-3 border p-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="{{ $sizeKey }}" name="size[{{ $key }}][]"
                                                        id="size{{ $sizeKey }}{{ $key }}"
                                                        {{ in_array($sizeKey, old('size.' . $key, [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="size{{ $sizeKey }}{{ $key }}">{{ $sizeValue }}</label>
                                                </div>
                                                <div class="mt-2">
                                                    <label for="quantity{{ $sizeKey }}{{ $key }}" class="form-label">Số Lượng</label>
                                                    <input type="number" class="form-control" id="quantity{{ $sizeKey }}{{ $key }}"
                                                        name="quantity[{{ $key }}][{{ $sizeKey }}]" min="0" value="{{ old('quantity.' . $key . '.' . $sizeKey, 0) }}">
                                                </div>
                                                <div class="mt-2">
                                                    <label for="price{{ $sizeKey }}{{ $key }}" class="form-label">Giá</label>
                                                    <input type="number" class="form-control" id="price{{ $sizeKey }}{{ $key }}"
                                                        name="price[{{ $key }}][{{ $sizeKey }}]" min="0" value="{{ old('price.' . $key . '.' . $sizeKey, 0) }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary">Lưu Sản Phẩm</button>
                </div>
            </form>
    </div>
    </section>
    </div>
    <script>
      
        document.addEventListener('DOMContentLoaded', function() {
            let toastElements = document.querySelectorAll('.toast');
            toastElements.forEach(function(toastElement) {
                let toast = new bootstrap.Toast(toastElement);
                toast.show();
            });
        });
    </script>   
    @vite(['resources/js/user-create.js', 'resources/js/product.js', 'resources/css/product.css', 'resources/css/form-edit.css', 'resources/js/form.js'])
@endsection
