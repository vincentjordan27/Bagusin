<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mechanic;
use App\Models\Customer;
use App\Models\Order;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class MyOrderController extends Controller
{

    public function show(Request $request)
    {   
        if(Auth::guard('customer')->user()){
            $order = Order::where('customer_id', Auth::guard('customer')->user()->id)
            ->where('status', '=', 'waiting')
            ->orWhere('status', '=', 'done')
            ->orWhere('status', '=', 'accept')
            ->latest('created_at')
            ->first();

            $mechanic = NULL;
        if($order){
        $mechanic = Mechanic::where('id', $order->mechanic_id)->first();
        
        if($order->customer_rating != NULL){
            $order = NULL;
        }
    }
        return view('myorder', ['order' => $order, 'mechanic' => $mechanic]);
        }else{
            $order = Order::where('mechanic_id', Auth::guard('mechanic')->user()->id)->where('status', '!=', 'done')
            ->where('status', '!=', 'cancel')
            ->where('status', '!=', 'reject')
            ->latest('created_at')
            ->first();
            if($order){
            $customer = Customer::where('id', $order->customer_id)->first();
            }else{
                $customer = NULL;
            }
            $pics = [];
            if($order){
            for($x = 1 ; $x <= 4 ; $x++){
                array_push($pics, $order->{'problem_pic'. $x});
            }
        }
        return view('incomingorder', ['order' => $order, 'customer' => $customer, 'pics' => $pics]);

        }
    }

}