<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $this->seo()->setTitle('Home Page');
        return view('welcome');
    }





}
