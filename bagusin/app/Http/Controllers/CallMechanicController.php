<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mechanic;
use App\Models\Customer;
use App\Models\Order;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class CallMechanicController extends Controller
{

    public function show(Request $request)
    {   
        $order = Order::where('customer_id', Auth::guard('customer')->user()->id)
        ->where('status', '=', 'waiting')
        ->where('status', '=', 'accept')
        ->first();
        if($order){
            return redirect()->route('currentorder');
        }
        if(!Auth::guard('customer')->user()){
            return redirect()->route('masuk');
        }
        return view('panggilmekanik', ['id' => $request->id]);
    }

    public function callmechanic(Request $request, $id)
    {   
        $request->validate([
            'problem_pic1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'problem_pic2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'problem_pic3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'problem_pic4' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'problem' => 'bail|required|max:190',
            'phone' => 'bail|required|numeric|digits_between:10,13',
            'location' => 'bail|required|max:100',
        ]);

        for ($x = 1; $x <= 4; $x++) {
            $requestfile = 'problem_pic'. $x;
            if($request->hasFile($requestfile)){
                ${'problem_pic' . $x . 'name'} = time(). rand(1000,2000) .'.'.$request->$requestfile->extension();
                $request->$requestfile->move(public_path('images'), ${'problem_pic' . $x . 'name'});
            }
        }
        

        $order = Order::create([
            'problem_description' => trim($request->input('problem')),
            'customer_phone' => trim($request->input('phone')),
            'address' => trim($request->input('location')),
            'problem_pic1' => $problem_pic1name,
            'mechanic_id' => $request->id,
            'customer_id' => Auth::guard('customer')->user()->id
        ]);

        for ($x = 2; $x <= 4; $x++) {
            $requestfile = 'problem_pic'. $x;
            if($request->hasFile($requestfile)){
                $order->$requestfile = ${'problem_pic' . $x . 'name'};
            }
        }
        $order->save();
        $mechanic = Mechanic::where('id', $id)->first();
        $mechanic->hasorder = 1;
        $mechanic->save();
        return redirect('/myorder');
    }


}