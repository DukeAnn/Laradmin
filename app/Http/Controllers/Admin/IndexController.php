<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    //
    public function index()
    {
        return view('admin.index');
    }

    public function icon()
    {
        return view('admin.icon');
    }
}
