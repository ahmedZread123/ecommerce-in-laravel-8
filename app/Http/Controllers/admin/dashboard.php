<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class dashboard extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function dashboardvendor()
    {
        return view('vendor.dashboard');
    }

}
