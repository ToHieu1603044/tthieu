<?php

namespace App\Livewire;

use App\Helpers\TextSystemConst;
use App\Models\Category;
use Livewire\Component;

class CategoryShow extends Component
{
    public $parent_ids;
    public $category_id;
    public $category;

    public $name, $description, $status, $slug, $parent_id;

    protected function rules()
    {
        return [
            'name' => 'required',
            'slug' => 'required',
            'description' => 'nullable',
            'status' => 'required',
            'parent_id' => 'nullable|exists:categories,id'
        ];
    }

    public function editCategory(int $id)
    {
        $category = Category::find($id);
        if ($category) {

            $this->category_id = $category->id;
            $this->name = $category->name;
            $this->slug = $category->slug;
            $this->description = $category->description;
            $this->status = $category->status;
            $this->parent_id = $category->parent_id;
        } else {

            session()->flash('error', 'Danh mục không tồn tại.');

            return redirect()->route('categories.index');
        }
    }

    public function closeModal()
    {
        $this->resetInput();
    }

    public function updateCategory()
    {
        try {
            $validated = $this->validate();

            Category::where('id', $this->category_id)->update($validated);

            session()->flash('message', TextSystemConst::UPDATE_SUCCESS);

            $this->resetInput();
        } catch (\Throwable $th) {
            session()->flash('error', TextSystemConst::UPDATE_FAILED);
        }

    }

    public function saveCategory()
    {
        try {
            $validated = $this->validate();

            Category::create($validated);

            session()->flash('message', TextSystemConst::CREATE_SUCCESS);
        } catch (\Exception $e) {
            session()->flash('error', TextSystemConst::CREATE_FAILED);
        }
    }

    public function resetInput()
    {
        $this->name = '';
        $this->slug = '';
        $this->description = '';
        $this->status = '';
        $this->parent_id = '';
    }

    public function render()
    {
        $this->parent_ids = Category::where('parent_id', null)->get(['id', 'name']);

        $this->category = Category::whereNotNull('parent_id')->get();

        return view('livewire.category-show', [
            'parent_ids' => $this->parent_ids,
            'category' => $this->category,
        ]);
    }
    public function deleteCategory(int $id)
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                session()->flash('error', 'Danh mục không tồn tại.');
                return redirect()->route('categories.index');
            }

            $category->delete();

            
            session()->flash('message', 'Danh mục đã được xóa thành công.');

        } catch (\Exception $e) {
            // Bắt lỗi và hiển thị thông báo lỗi
            session()->flash('error', 'Có lỗi xảy ra khi xóa danh mục. Lỗi: ' . $e->getMessage());
        }
    }

}

