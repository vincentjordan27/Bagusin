<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mechanic;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Admin;


use Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class AdminController extends Controller
{

    public function doLogin(Request $request)
    {   
        $request->validate([
            'email' => 'bail|required|email|max:100',
            'password' => 'bail|required|min:8|max:100',
        ]);

        $credentials = $request->except(['_token']);

        $admin = Admin::where('email', $request->email)->first();

        if (auth()->guard('admin')->attempt($credentials)) {

            return redirect('/admin/dashboard');

        }else{
            session()->flash('message', 'Invalid credentials');
            return redirect()->back();
        }
    }

    public function showLogin(){
        if(Auth::guard('admin')->user()){
            return redirect('/admin/dashboard');
        }

        return view('adminlogin');
    }

    public function dashboard(Request $request)
    {   
        if(!Auth::guard('admin')->user()){
            return redirect('/admin/login');
        }
        $customers = Customer::all()->count();
        $mechanics = Mechanic::all()->count();
        $orders = Order::all()->count();
        return view('admindashboard', ['customers' => $customers, 'mechanics' => $mechanics, 'orders' => $orders]);
    }

    public function showCustomers(Request $request)
    {   
        if(!Auth::guard('admin')->user()){
            return redirect('/admin/login');
        }
        $customers = Customer::where('id', '!=', 0)->paginate(10);
        return view('admincustomers', ['customers' => $customers]);
    }

    public function showMechanics(Request $request)
    {   
        if(!Auth::guard('admin')->user()){
            return redirect('/admin/login');
        }
        $mechanics = Mechanic::where('id', '!=', 0)->paginate(10);
        return view('adminmechanics', ['mechanics' => $mechanics]);
    }

    public function showOrders(Request $request)
    {   
        if(!Auth::guard('admin')->user()){
            return redirect('/admin/login');
        }
        $orders = Order::where('id', '!=', 0)->paginate(10);
        return view('adminorders', ['orders' => $orders]);
    }


}