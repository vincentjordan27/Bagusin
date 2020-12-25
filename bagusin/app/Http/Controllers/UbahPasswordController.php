<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Mechanic;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use DB;
use Hash;

class UbahPasswordController extends Controller
{

    public function show()
    {
        if(Auth::guard('customer')->user() or Auth::guard('mechanic')->user()){
            return view('ubahpassword');
        }
        return redirect()->route('masuk');
    }

    public function changepassword(Request $request)
    {   
        $request->validate([
            'password' => 'bail|required|min:8|max:100',
            'newpassword' => 'bail|required|min:8|max:100',
            'confirmnewpassword' => 'bail|required|same:newpassword'
        ]);
        
        /*$credentials = $request->except(['_token']);*/

        /* If the action was done by customer */
        if (Auth::guard('customer')->user()){
            $customer_email = Auth::guard('customer')->user()->email;

            $customer = Customer::where('email', $customer_email)->first();

            if (Hash::check($request->input('password'), $customer->password)) {

                $newpassword = bcrypt($request->input('newpassword'));

                $customer->password = $newpassword;
                $customer->save();

                return redirect()->back()->withInput()->with('message', "Password berhasil diubah!");

            }else{

                session()->flash('error', 'Kata Sandi Lama Salah.');
                return redirect()->back();
            }

        /* If the action was done by mechanic */
        }else if(Auth::guard('mechanic')->user()){
            $mechanic_email = Auth::guard('mechanic')->user()->email;

            $mechanic = Mechanic::where('email', $mechanic_email)->first();
            if (Hash::check($request->input('password'), $customer->password)) {

                $newpassword = bcrypt($request->input('newpassword'));

                $mechanic->password = $newpassword;
                $mechanic->save();

                return redirect()->back()->withInput()->with('message', "Password berhasil diubah!");

            }else{

                session()->flash('error', 'Kata Sandi Lama Salah.');
                return redirect()->back();
            }
        }
        
        return redirect()->back()->withInput()->with('message', "Detail akun berhasil diubah!");
    }

}