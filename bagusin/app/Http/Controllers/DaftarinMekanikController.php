<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mechanic;
use Auth;
use Illuminate\Http\Request;

class DaftarinMekanikController extends Controller
{

    public function show()
    {   
        if(Auth::guard('customer')->user()){
            return redirect('/');
        }
        return view('daftarmekanik');
    }

    public function daftarmekanik(Request $request)
    {   
        $request->validate([
            'name' => 'bail|required|max:50',
            'email' => 'bail|required|email|max:100|unique:mechanics,email',
            'phone' => 'bail|required|numeric|digits_between:10,13',
            'address' => 'bail|required|max:100',
            'password' => 'bail|required|min:8|max:100',
            'confirm_password' => 'bail|required|same:password',
            'services' => 'bail|required|max:100',
            'servicedescription' => 'bail|required|max:190',
        ]);

        $customer = Mechanic::create([
            'name' => trim($request->input('name')),
            'email' => strtolower($request->input('email')),
            'phone' => strtolower($request->input('phone')),
            'address' => trim($request->input('address')),
            'password' => bcrypt($request->input('password')),
            'services' => trim($request->input('services')),
            'servicedescription' => trim($request->input('servicedescription')),
        ]);

        return redirect()->back()->withInput()->with('message', "Akun berhasil dibuat!");
    }
}