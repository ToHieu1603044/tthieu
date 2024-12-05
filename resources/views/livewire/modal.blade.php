<div wire:ignore.self class="modal fade" id="categoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Thêm mới</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="saveCategory" method="post">

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Tên danh mục</label>
                        <input type="text" class="form-control" id="name" aria-describedby="emailHelp"
                            wire:model='name'>
                        @error('name')
                            <div id="slug" class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" aria-describedby="slug" name='slug'
                            wire:model='slug'>

                    </div>
                    @error('slug')
                        <div id="slug" class="form-text  text-danger">{{ $message }}</div>
                    @enderror
                    <div class="mb-3">
                        <label for="parent_id" class="form-label">Danh mục cha</label>
                        <select id="parent_id" class="form-select" name="parent_id" wire:model="parent_id">
                            <option value="">Chọn danh mục cha</option>
                            @foreach ($parent_ids as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="card card-outline card-info col-12">
                        <div class="card-header">
                            <h3 class="card-title">
                                Mô Tả
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <textarea id="summernote" name="description" wire:model='description'>
                       </textarea>
                        </div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" value="1" name="status" class="form-check-input" id="exampleCheck1"
                            wire:model='status'>
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>




<div wire:ignore.self class="modal fade" id="updatecategoryModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Chỉnh sửa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click = "closeModal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="updateCategory" method="post">

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Tên danh mục</label>
                        <input type="text" class="form-control" id="name" aria-describedby="emailHelp"
                            wire:model='name'>
                        @error('name')
                            <div id="slug" class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" aria-describedby="slug"
                            name='slug' wire:model='slug'>

                    </div>
                    @error('slug')
                        <div id="slug" class="form-text  text-danger">{{ $message }}</div>
                    @enderror
                    <div class="mb-3">
                        <label for="parent_id" class="form-label">Danh mục cha</label>
                        <select id="parent_id" class="form-select" name="parent_ids" wire:model='parent_ids'>
                            <option value="">Disabled select</option>
                            @foreach ($parent_ids as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="card card-outline card-info col-12">
                        <div class="card-header">
                            <h3 class="card-title">
                                Mô Tả
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <textarea id="summernote" name="description" wire:model='description'>
                       </textarea>
                        </div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" value="1" class="form-check-input" id="exampleCheck1"
                            wire:model="status">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    wire:click = "closeModal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>
