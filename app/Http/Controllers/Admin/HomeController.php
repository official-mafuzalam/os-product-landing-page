<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //

    public function index()
    {
        $userRoles = auth()->user()->getRoleNames();

        return view('admin.index');



        // echo "<pre>";
        // print_r($userRoles->toArray());

    }
}