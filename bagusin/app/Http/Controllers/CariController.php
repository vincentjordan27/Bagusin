<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mechanic;
use App\Models\Customer;
use App\Models\Order;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class CariController extends Controller
{

    public function show(Request $request)
    {   

        $query = $request->input('query');
        $mechanics = Mechanic::where('name', 'like', '%' . $query . '%')->
        orWhere('services', 'like', '%' . $query . '%')->
        orWhere('servicedescription', 'like', '%' . $query . '%')->
        get()->toArray();

        return view('search', ['mechanics' => $mechanics]);
    }

}