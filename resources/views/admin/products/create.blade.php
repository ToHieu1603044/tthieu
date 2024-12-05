@extends('main')
@section('content')
    {{-- @dd('admin.categorybyparent') --}}
    <section section class="content">
        <div class="container-fluid">
            <div class="row">
            </div>

            <form class="row" action="{{ route('products.store') }}" method="POST" id="form__js"
                enctype="multipart/form-data">
                @csrf
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="card card-default">
                        <div class="card-header">

                            <h3 class="card-title">Thông tin cơ bản</h3>
                           
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
                                        <input id="name" type="text" name="name" class="form-control">
                                    </x-admin-input-prepend>
                                    <x-admin-input-prepend label="Giá Nhập" col="col-6" width="auto">
                                        <input id="price_import" type="number" min="1" name="price_buy"
                                            class="form-control">
                                    </x-admin-input-prepend>
                                    <x-admin-input-prepend label="Số lượng " col="col-6" width="auto">
                                        <input id="stock" type="number" min="1" name="stock"
                                            class="form-control">
                                    </x-admin-input-prepend>

                                    <x-admin-input-prepend label="Màu sắc" width="auto" col="col-6">
                                        <select class="form-control" name="color" id="color">
                                            @foreach ($colors as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </x-admin-input-prepend>


                                    <x-admin-input-prepend label="Giá Bán" col="col-6" width="auto">
                                        <input id="price_sell" type="number" name="price_sell" class="form-control">
                                    </x-admin-input-prepend>
                                    <x-admin-input-prepend label="Kích thước" width="auto" col="col-6">
                                        <select class="form-control" name="size" id="sizes">
                                            @foreach ($sizes as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </x-admin-input-prepend>
                                    <x-admin-input-prepend label="Thời trang" width="auto" col="col-6">
                                        <select class="form-control" name="parent_id" id="parent_id">
                                            <option value="">...</option>
                                            @foreach ($categories as $categoryParent)
                                                <option value="{{ $categoryParent->id }}">{{ $categoryParent->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </x-admin-input-prepend>
                                    <x-admin-input-prepend label="Danh Mục" width="auto">
                                        <select class="form-control" name="category_id" id="category_id"
                                            route="{{ route('admin.category_by_parent') }}">
                                            @foreach ($categories as $category)
                                                @foreach ($category->children as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}
                                                </option>
                                                @endforeach
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
    </section>
    @vite(['resources/js/user-create.js', 'resources/js/product.js', 'resources/css/product.css', 'resources/css/form-edit.css', 'resources/js/form.js'])
@endsection
