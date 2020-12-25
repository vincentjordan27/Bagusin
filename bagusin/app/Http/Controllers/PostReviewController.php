<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Mechanic;
use Auth;
use Illuminate\Http\Request;

class PostReviewController extends Controller
{

    public function postreview(Request $request, $id)
    {   
        $order = Order::where('id', $id)->first();
        $request->validate([
            'text' => 'bail|required|max:50',
            'score' => 'bail|required|numeric',
        ]);
        $mechanic = Mechanic::where('id', $order->mechanic_id)->first();
        $mechanic->score = $mechanic->score + $request->input('score');
        $mechanic->reviews_number = $mechanic->reviews_number + 1;
        $mechanic->save();

        $order->customer_review = $request->input('text');
        $order->customer_rating = $request->input('score');
        $order->save();
        return response()->json(['status' => 'dsaad']);
    }
}