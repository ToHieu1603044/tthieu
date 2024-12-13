<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function __construct(){
        $this->middleware('permission:view category', ['only' => ['index']]);
       
        $this->middleware('permission:create category', ['only' => ['create']]);
       
      }
    public function index()
    {
        return view('admin.category.index');
    }
    public function create()
    {
        return view('admin.category.create');
    }
    public function getChildren($id)
    {
        // Find the category by its ID and load its children
        $category = Category::find($id);
        
        if ($category) {
            // Return the children categories as JSON
            return response()->json($category->children); // Assumes you have the 'children' relationship defined in the model
        }

        // Return an empty array if no category is found
        return response()->json([]);
    }


}
