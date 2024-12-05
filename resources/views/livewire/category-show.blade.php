<div>
    @include('livewire.modal')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if (session()->has('message'))
                    <h5 class="alert alert-default-success">{{ session('message') }}</h5>
                @endif
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#categoryModal">
                            Thêm mới danh mục
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Loại</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($category as $item)
                                    <tr>
                                        <th scope="row">{{ $item->id }}</th>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->slug }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>
                                            @if ($item->parent_id == 16)
                                                Nam
                                            @else
                                                Nữ
                                            @endif
                                        </td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            <button class="btn btn-success" type="button"
                                                wire:click="editCategory({{ $item->id }})" data-bs-toggle="modal"
                                                data-bs-target="#updatecategoryModal">Sửa</button>
                                                
                                            <button class="btn btn-danger"
                                                wire:click="deleteCategory({{ $item->id }})">Xóa</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
