<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

class KeluarController extends Controller
{

    public function keluar(Request $request)
    {
        $request->session()->invalidate();
        return redirect('/masuk');
    }

}