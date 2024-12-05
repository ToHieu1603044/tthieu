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


}