<?php

<<<<<<< HEAD
namespace App\View\Components\Seller;
=======
namespace App\View\Components\Seller; 
>>>>>>> ebfc4954a7944547f27ae325f91ba0ca757b5deb

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Content extends Component
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
