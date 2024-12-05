<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableCrud extends Component
{
    public $headers;
    public $list;
    public $actions;
    public $routes;

    public function __construct($headers, $list, $actions, $routes)
    {
        $this->headers = $headers;
        $this->list = $list;
        $this->actions = $actions;
        $this->routes = $routes;
    }

    public function render()
    {
        return view('components.table-crud');
    }
}

