<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public $hello = 121;
    public function index(){
        return view('admin.dashboard');
    }
}
