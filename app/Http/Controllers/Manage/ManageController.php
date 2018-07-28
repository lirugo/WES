<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;

class ManageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('manage.index');
    }
}
