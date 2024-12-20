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

        <header class="card-header bg-primary text-white mb-5">Sản phẩm / Thêm sản phẩm</header>
        <ul class="nav nav-tabs" id="productTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="product-details-tab" data-bs-toggle="tab" href="#product-details"
                    role="tab" aria-controls="product-details" aria-selected="true">Sản Phẩm</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="product-variants-tab" data-bs-toggle="tab" href="#product-variants" role="tab"
                    aria-controls="product-variants" aria-selected="false">Biến Thể Sản Phẩm</a>
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

                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}" {{ old('parent_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Danh mục</label>
                        <select class="form-select" id="category" name="category_id">

                            @foreach ($categories as $category)
                                @foreach ($category->children as $item)
                                    <option value="{{ $item->id }}" data-parent="{{ $category->id }}"
                                        {{ old('category_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
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
                    <ul class="nav nav-tabs" id="sizeTab" role="tablist">
                        @foreach ($sizes as $sizeKey => $sizeValue)
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="size-tab-{{ $sizeKey }}" data-bs-toggle="tab"
                                    href="#size-{{ $sizeKey }}" role="tab" aria-controls="size"
                                    aria-selected="">{{ $sizeValue }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content mt-3">
                        @foreach ($sizes as $sizeKey => $sizeValue)
                            <div class="tab-pane fade"
                                id="size-{{ $sizeKey }}" role="tabpanel"
                                aria-labelledby="size-tab-{{ $sizeKey }}">
                                <div class="mb-3">
                                    <label class="form-label">Chọn Màu Sắc ({{ $sizeValue }})</label>
                                    <input type="checkbox" name="size[]" value="{{ $sizeKey }}">
                                    @foreach ($colors as $key => $value)
                                        <div class="mb-3 border p-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    value="{{ $key }}" name="color[{{ $sizeKey }}][]"
                                                    id="color{{ $key }}{{ $sizeKey }}"
                                                    {{ in_array($key, old('color.' . $sizeKey, [])) ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold"
                                                    for="color{{ $key }}{{ $sizeKey }}">{{ $value }}</label>
                                            </div>
                                            <!-- Số lượng và giá -->
                                            <div class="mt-2">
                                                <label for="quantity{{ $sizeKey }}{{ $key }}"
                                                    class="form-label">Số Lượng</label>
                                                <input type="number" class="form-control"
                                                    id="quantity{{ $sizeKey }}{{ $key }}"
                                                    name="quantity[{{ $sizeKey }}][{{ $key }}]"
                                                    min="0"
                                                    value="{{ old('quantity.' . $sizeKey . '.' . $key, 0) }}">
                                            </div>
                                            <div class="mt-2">
                                                <label for="price{{ $sizeKey }}{{ $key }}"
                                                    class="form-label">Giá</label>
                                                <input type="number" class="form-control"
                                                    id="price{{ $sizeKey }}{{ $key }}"
                                                    name="price[{{ $sizeKey }}][{{ $key }}]"
                                                    min="0"
                                                    value="{{ old('price.' . $sizeKey . '.' . $key, 0) }}">
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

        document.addEventListener('DOMContentLoaded', function() {
            const parentCategory = document.getElementById('parentCategory');
            const category = document.getElementById('category');

            parentCategory.addEventListener('change', function() {
                const selectedParent = this.value;

                Array.from(category.options).forEach(option => {
                    if (option.value === "") {
                        option.hidden = false;
                    } else {
                        const parentId = option.getAttribute('data-parent');
                        option.hidden = parentId !== selectedParent;
                    }
                });

                category.value = "";
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            // Lấy tất cả các tab và checkbox kích thước
            const sizeTabs = document.querySelectorAll('#sizeTab .nav-link');
            const sizeCheckboxes = document.querySelectorAll('input[name="size[]"]');

            sizeTabs.forEach(tab => {
                tab.addEventListener('shown.bs.tab', function(event) {
                    // Lấy ID của tab hiện tại (kích thước)
                    const sizeId = tab.getAttribute('href').replace('#size-', '');

                    // Tìm checkbox tương ứng và tự động check
                    sizeCheckboxes.forEach(checkbox => {
                        if (checkbox.value === sizeId) {
                            checkbox.checked = true;
                        }
                    });
                });
            });
        });
    </script>
    @vite(['resources/js/user-create.js', 'resources/js/product.js', 'resources/css/product.css', 'resources/css/form-edit.css', 'resources/js/form.js'])
@endsection
