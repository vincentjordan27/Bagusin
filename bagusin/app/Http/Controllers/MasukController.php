<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

class MasukController extends Controller
{

    public function show()
    {
        if(Auth::guard('customer')->user()){
            return redirect('/');
        }
        return view('masuk');
    }

    public function masuk(Request $request){
        $request->validate([
            'email' => 'bail|required|email|max:100',
            'password' => 'bail|required|min:8|max:100',
        ]);

        $credentials = $request->except(['_token']);

        $customer = Customer::where('email', $request->email)->first();

        if (auth()->guard('customer')->attempt($credentials)) {

            return redirect('/');

        }else{
            session()->flash('message', 'Invalid credentials');
            return redirect()->back();
        }
    }

}