<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;

class IndexController extends Controller
{

    public function show()
    {
        return view('index');
    }
}