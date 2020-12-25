<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mechanic;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

class MasukMekanikController extends Controller
{

    public function show()
    {
        if(Auth::guard('mechanic')->user()){
            return redirect('/');
        }
        return view('masukmekanik');
    }

    public function masuk(Request $request){
        $request->validate([
            'email' => 'bail|required|email|max:100',
            'password' => 'bail|required|min:8|max:100',
        ]);

        $credentials = $request->except(['_token']);

        $customer = Mechanic::where('email', $request->email)->first();

        if (auth()->guard('mechanic')->attempt($credentials)) {

            return redirect('/');

        }else{
            session()->flash('message', 'Invalid credentials');
            return redirect()->back();
        }
    }

}