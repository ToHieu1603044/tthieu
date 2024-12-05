<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CreateProduct extends Component
{
    public $category;
    public $colors;
    public $sizes;
    public $parent;
    public $product;

    public function __construct($category, $colors,$sizes,$parent,$product)
    {
        $this->category = $category;
        $this->colors = $colors;
        $this->sizes = $sizes;
        $this->parent = $parent;
        $this->product = $product;
    }

    public function render()
    {
        return view('components.admin-input-prepend');
    }
}