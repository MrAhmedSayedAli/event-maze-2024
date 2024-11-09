<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class UserLayout extends Component
{

    /**
     * @inheritDoc
     */
    public function render(): View
    {
        return view('layouts.user');
    }
}
