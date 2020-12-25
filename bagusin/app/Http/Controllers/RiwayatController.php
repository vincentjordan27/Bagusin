<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mechanic;
use App\Models\Customer;
use App\Models\Order;

use Auth;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{

    public function show()
    {   
        if(Auth::guard('customer')->user()){
            $orders = Order::where('customer_id', Auth::guard('customer')->user()->id)->paginate(5);
            foreach($orders as $order){
            $customer = Customer::where('id', $order->customer_id)->first();
            $mechanic = Mechanic::where('id', $order->mechanic_id)->first();
            $order['customer_name'] = $customer->name;
            $order['mechanic_name'] = $mechanic->name;
            }

        }else if(Auth::guard('mechanic')->user()){
            $orders = Order::where('mechanic_id', Auth::guard('mechanic')->user()->id)->paginate(5);
            foreach($orders as $order){
                $customer = Customer::where('id', $order->customer_id)->first();
                $mechanic = Mechanic::where('id', $order->mechanic_id)->first();
                $order['customer_name'] = $customer->name;
                $order['mechanic_name'] = $mechanic->name;
            }
        }
        return view('riwayat', ['orders' => $orders]);
    }

}