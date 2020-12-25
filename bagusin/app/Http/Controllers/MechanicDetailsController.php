<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mechanic;
use App\Models\Customer;
use App\Models\Order;

use Auth;
use Illuminate\Http\Request;

class MechanicDetailsController extends Controller
{

    public function show($id)
    {
        $mechanic = Mechanic::where('id', $id)->first();
        $pics = [];
        for ($x = 1; $x <= 4; $x++) {
            if($mechanic->{'garage_photo_path' . $x} != NULL){
                array_push($pics, $mechanic->{'garage_photo_path' . $x});
            }
        }

        return view('mechanicdetails', ['mechanic' => $mechanic, 'pics' => $pics]);
    }

}