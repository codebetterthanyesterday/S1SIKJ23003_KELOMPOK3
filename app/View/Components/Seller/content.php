<?php

namespace App\View\Components\Seller;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class content extends Component
{
    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.seller.content');
    }
}
