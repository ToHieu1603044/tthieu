@extends('main')
@section('content')
    {{-- @dd('admin.categorybyparent') --}}
    <section section class="content">
        <div class="container-fluid">
            <div class="row">
            </div>

            <form class="row" action="{{ route('products.update', $product) }}" method="POST" id="form__js"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin cơ bản</h3>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (session()->has('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="row">
                            <div class="col-8">
                                <div class="card-body row">
                                    <x-admin-input-prepend label="Tên Sản Phẩm" width="auto">
                                        <input id="name" type="text" name="name" class="form-control"
                                            value="{{ $product->name }}">
                                    </x-admin-input-prepend>
                                   
                                    <x-admin-input-prepend label="Giá Nhập" col="col-6" width="auto">
                                        <input id="price_import" type="number" min="1" name="price_buy"
                                            class="form-control" value="{{ $product->price_buy }}">
                                    </x-admin-input-prepend>
                                    
                                    <x-admin-input-prepend label="Số lượng " col="col-6" width="auto">
                                        <input id="stock" type="number" min="1" name="stock"
                                            class="form-control" value="{{ $stock[0] }}">
                                    </x-admin-input-prepend>

                                    <x-admin-input-prepend label="Màu sắc" width="auto" col="col-6">
                                        <select class="form-control" name="color" id="color">
                                            @foreach ($colors as $key => $value)
                                                <option @selected(in_array($key, $productColors)) value="{{ $key }}">
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </x-admin-input-prepend>


                                    <x-admin-input-prepend label="Giá Bán" col="col-6" width="auto">
                                        <input id="price_sell" type="number" name="price_sell" class="form-control"
                                            value="{{ $product->price_sell }}">
                                    </x-admin-input-prepend>
                                    <x-admin-input-prepend label="Kích thước" width="auto" col="col-6">
                                        <select class="form-control" name="size" id="sizes">
                                            @foreach ($sizes as $key => $value)
                                                <option @selected(in_array($key, $productSize)) value="{{ $key }}">
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </x-admin-input-prepend>
                                    <x-admin-input-prepend label="Danh mục cha" width="auto" col="col-6">
                                        <select class="form-control" name="parent_id" id="parent_id">
                                            <option value="">Chọn danh mục con</option>
                                            {{-- @foreach ($parent as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach --}}
                                        </select>
                                    </x-admin-input-prepend>
                                    <x-admin-input-prepend label="Danh Mục Con" width="auto">
                                        <select class="form-control" name="category_id" id="category_id">
                                            @foreach ($category as $key => $value)
                                                <option @selected($product->category_id == $key) value="{{ $key }}">
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </x-admin-input-prepend>
                                    <div class="mb-3 form-check">
                                        <input type="radio"  class="form-check-label" name="status" value="1" > Còn hàng
                                        <input type="radio"  class="form-check-label" name="status" value="0" > Hết hàng
                                       </div>
                                     <div class="card card-outline card-info col-12">
                                         <div class="card-header">
                                             <h3 class="card-title">
                                                 Mô Tả ngắn
                                             </h3>
                                         </div>
                                         <!-- /.card-header -->
                                         <div class="card-body">
                                             <textarea id="summernote" name="description">
                                            </textarea>
                                         </div>
                                     </div>
 
                                     <div class="card card-outline card-info col-12">
                                         <div class="card-header">
                                             <h3 class="card-title">
                                                 Mô Tả Sản dài
                                             </h3>
                                         </div>
                                         <!-- /.card-header -->
                                         <div class="card-body">
                                             <textarea id="summernote" name="descriptions">
                                            </textarea>
                                         </div>
                                     </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="preview">
                                            <img id="img-preview" src="" />
                                            <label for="file-input">Chọn Hình Ảnh</label>
                                            <input accept="image/*" type="file" id="file-input" name="img" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center" style="padding-bottom: 10px;">
                                <button class="btn btn-success">THÊM MỚI</button>
                                <a href="{{ route('products.index') }}" class="btn btn-danger">HỦY</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    @vite(['resources/admin/js/user-create.js', 'resources/admin/js/product.js', 'resources/admin/css/product.css', 'resources/admin/css/form-edit.css', 'resources/common/js/form.js'])
@endsection
