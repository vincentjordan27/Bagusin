<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Use App\Models\Customer;
Use App\Models\Mechanic;
Use App\Models\Order;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


/* Customer Login */

Route::middleware('guest:api')->post('/logincustomer', function (Request $request) {
    $customer = Customer::where('email', $request->input('email'))->first();

    if(!$customer){
        return response()->json(['status' => false]);;
    }

    if (Hash::check($request->input('password'), $customer->password)){
        return response()->json(['status' => true, 'customer_id' => $customer->id]);
    }

    return response()->json(['status' => false]);
});

/* Mechanic Login */

Route::middleware('guest:api')->post('/loginmechanic', function (Request $request) {
    $mechanic = Mechanic::where('email', $request->input('email'))->first();
    if(!$mechanic){
        return response()->json(['status' => false]);
    }
    if (Hash::check($request->input('password'), $mechanic->password)){
        return response()->json(['status' => true, 'mechanic_id' => $mechanic->id]);
    }

    return response()->json(['status' => false]);
});

/* Get Customer Data by email */

Route::middleware('guest:api')->get('/getcustomerdata/{id}', function ($id) {
    $customer = Customer::where('id', $id)->first();

    if(!$customer){
        return response()->json(['status' => false], 404);
    }
    return response()->json($customer, 200);
});

/* Get Mechanic Data by email */

Route::middleware('guest:api')->get('/getmechanicdata/{id}', function ($id) {
    $mechanic = Mechanic::where('id', $id)->first();

    return response()->json($mechanic, 200);
});

/* Check registered customer */

Route::middleware('guest:api')->get('/checkcustomer/{email}', function ($email) {
    $customer = Customer::where('email', $email)->first();
    if($customer){
        return response()->json(['status' => true]);
    }
    return response()->json(['status' => false]);
});

/* Check registered mechanic */

Route::middleware('guest:api')->get('/checkmechanic/{email}', function ($email) {
    $mechanic = Mechanic::where('email', $email)->first();
    if($mechanic){
        return response()->json(['status' => true]);
    }
    return response()->json(['status' => false]);
});

/* Customer Registration */
Route::middleware('guest:api')->post('/customer_registration', function (Request $request) {

    try {
        $customer = Customer::create([
            'name' => trim($request->input('name')),
            'email' => strtolower($request->input('email')),
            'phone' => strtolower($request->input('phone')),
            'address' => trim($request->input('address')),
            'password' => bcrypt($request->input('password')),
        ]);
    } catch (Throwable $e) {
        report($e);

        return response()->json(['status' => false]);
    }


    return response()->json(['status' => true, 'customer_id' => $customer->id]);
});

/* Mechanic Registration */

Route::middleware('guest:api')->post('/mechanic_registration', function (Request $request) {

    try {
        $mechanic = Mechanic::create([
            'name' => trim($request->input('name')),
            'email' => strtolower($request->input('email')),
            'phone' => strtolower($request->input('phone')),
            'address' => trim($request->input('address')),
            'password' => bcrypt($request->input('password')),
            'services' => trim($request->input('services')),
            'servicedescription' => trim($request->input('servicedescription')),
        ]);
    } catch (Throwable $e) {
        var_dump($e);
        die();
        report($e);

        return response()->json(['status' => false]);
    }


    return response()->json(['status' => true, 'mechanic_id' => $mechanic->id]);
});

/* Search mechanic */

Route::middleware('guest:api')->get('search_mechanic/{query}', function($query){
    $mechanic_byname = Mechanic::where('name', 'like', '%' . $query . '%')->get()->toArray();
    $mechanic_byservices = Mechanic::where('services', 'like', '%' . $query . '%')->get()->toArray();
    $mechanic_bydescription = Mechanic::where('servicedescription', 'like', '%' . $query . '%')->get()->toArray();

    $mechanic = array_merge($mechanic_bydescription, $mechanic_byname, $mechanic_byservices);
    $keys = [];
    $result = [];
    $count = 0;
    foreach($mechanic as $mec){
        if(!in_array($mec['id'], $keys)){
            array_push($result, $mec);
            array_push($keys, $mec['id']);
            $count++;
        }
    }

    return response()->json(['result' => array($mec), 'count' => $count]);
});

/* Create Order */

Route::middleware('guest:api')->post('/create_order', function (Request $request) {

    $request->validate([
        'problem_pic1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        'problem_pic2' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        'problem_pic3' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        'problem_pic4' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
    ]);

    for ($x = 1; $x <= 4; $x++) {
        $requestfile = 'problem_pic'. $x;
        if($request->hasFile($requestfile)){
            ${'problem_pic' . $x . 'name'} = time(). rand(1000,2000) .'.'.$request->$requestfile->extension();
            $request->$requestfile->move(public_path('images'), ${'problem_pic' . $x . 'name'});
        }
    }

    try {
        
        $order = Order::create([
            'mechanic_id' => trim($request->input('mechanic_id')),
            'customer_id' => trim($request->input('customer_id')),
            'problem_description' => trim($request->input('problem_description')),
            'address' => trim($request->input('address')),
            'problem_pic1' => $problem_pic1name,
            'customer_phone' => $request->customer_phone
        ]);
        
        for ($x = 2; $x <= 4; $x++) {
            $requestfile = 'problem_pic'. $x;
            if($request->hasFile($requestfile)){
                $order->$requestfile = ${'problem_pic' . $x . 'name'};
            }
        }
        
        $order->save();
        
        $mechanic = Mechanic::where('id', $request->input('mechanic_id'))->first();

        $mechanic->hasorder = 1;

        $mechanic->save();


    } catch (Throwable $e) {
        echo($e);
        die();
        return response()->json(['status' => false]);
    }

    return response()->json(['status' => true, 'order_id' => $order->id]);
});

/* Get Order by id */

Route::middleware('guest:api')->get('/getorderdata/{id}', function ($id) {
    $order = Order::where('id', $id)->first();
    if(!$order){
        return response()->json(['status' => false]);
    }
    $customer = Customer::where('id', $order->customer_id)->first();
    $mechanic = Mechanic::where('id', $order->mechanic_id)->first();
    $order['customer_name'] = $customer->name;
    $order['mechanic_name'] = $mechanic->name;

    return response()->json($order, 200);
});

/* Get Order by mechanic */

Route::middleware('guest:api')->get('/getordersbymechanic/{id}', function ($id) {
    $orders = Order::where('mechanic_id', $id)->orderBy('id', 'DESC')->get();
    foreach($orders as $order){
        $mechanic = Mechanic::where('id', $order->mechanic_id)->first();
        $customer = Customer::where('id', $order->customer_id)->first();
        $order['customer_name'] = $customer->name;
        $order['mechanic_name'] = $mechanic->name;

    }
    return response()->json(['result' => $orders, 'count' => count($orders)], 200);
});

/* Get order status by id */

Route::middleware('guest:api')->get('/getorderstatus/{id}', function ($id) {
    $order = Order::where('id', $id)->first();
    if(!$order){
        return response()->json(false);
    }
    return response()->json(['status' => $order->status], 200);
});

/* Get mechanic status by id */

Route::middleware('guest:api')->get('/hasorder/{id}', function ($id) {
    $mechanic = Mechanic::where('id', $id)->first();
    if(!$mechanic){
        return response()->json(['status' => 'not found'], 404);
    }
    return response()->json(['status' => (bool)$mechanic->hasorder], 200);
});


/* Updating order status     */

Route::middleware('guest:api')->post('/updateorder', function (Request $request) {

    try {
        $order = Order::where('id', $request->input('order_id'))->first();
        if($request->input('status') == 'accept'){
            $order->status = 'accept';
        }else if($request->input('status') == 'cancel'){
            $order->status = 'cancel';
            $mechanic = Mechanic::where('id', $order->mechanic_id)->first();
            $mechanic->hasorder = 0;
            $mechanic->save();
        }else if($request->input('status') == 'reject'){
            $order->status = 'reject';
            $mechanic = Mechanic::where('id', $order->mechanic_id)->first();
            $mechanic->hasorder = 0;
            $mechanic->save();
        }else if($request->input('status') == 'review'){
            $order->status = 'review';
        }else if($request->input('status') == 'done'){
            $order->status = 'done';
            $mechanic = Mechanic::where('id', $order->mechanic_id)->first();
            $mechanic->hasorder = 0;
            $mechanic->save();
        }

        $order->save();
    } catch (Throwable $e) {
        report($e);

        return response()->json(['status' => false]);
    }


    return response()->json(['status' => true]);
});

/* Get Order by customer */

Route::middleware('guest:api')->get('/getordersbycustomer/{id}', function ($id) {
    $orders = Order::where('customer_id', $id)->orderBy('id', 'DESC')->get();

    foreach($orders as $order){
        $mechanic = Mechanic::where('id', $order->mechanic_id)->first();
        $customer = Customer::where('id', $order->customer_id)->first();
        $order['customer_name'] = $customer->name;
        $order['mechanic_name'] = $mechanic->name;

    }

    return response()->json(['result' => $orders, 'count' => count($orders)], 200);
});


/* Review order */

Route::middleware('guest:api')->post('/review_order', function (Request $request) {

    try {
        $order = Order::where('id', $request->input('order_id'))->first();
        $order->customer_review = $request->input('customer_review');
        $order->customer_rating = $request->input('customer_rating');
        $order->status = 'done';
        $order->save();
        $mechanic = Mechanic::where('id', $order->mechanic_id)->first();
        $mechanic->hasorder = 0;
        $mechanic->save();
    } catch (Throwable $e) {
        report($e);
        return response()->json(['status' => false]);
    }

    return response()->json(['status' => true]);
});


/* Change customer password */

Route::middleware('guest:api')->post('/change_customerpassword', function (Request $request) {

    try {
        $customer = Customer::where('id', $request->input('customer_id'))->first();

        if (Hash::check($request->input('password'), $customer->password)) {

            $newpassword = bcrypt($request->input('newpassword'));

            $customer->password = $newpassword;
            $customer->save();

        }else{
            return response()->json(['status' => false]);
        }

    } catch (Throwable $e) {
        report($e);
        return response()->json(['status' => false]);
    }

    return response()->json(['status' => true]);
});

/* Change mechanic password */

Route::middleware('guest:api')->post('/change_mechanicpassword', function (Request $request) {

    try {
        $mechanic = Mechanic::where('id', $request->input('mechanic_id'))->first();

        if (Hash::check($request->input('password'), $mechanic->password)) {

            $newpassword = bcrypt($request->input('newpassword'));

            $mechanic->password = $newpassword;
            $mechanic->save();

        }else{
            return response()->json(['status' => false]);
        }

    } catch (Throwable $e) {
        report($e);
        return response()->json(['status' => false]);
    }

    return response()->json(['status' => true]);
});

/* Change customer profile */

Route::middleware('guest:api')->post('/change_customerdetails', function (Request $request) {

    try {
        $customer = Customer::where('id', $request->input('customer_id'))->first();
        $customer->name = $request->input('name');
        $customer->address = $request->input('address');
        $customer->phone = $request->input('phone');
        $customer->save();
    } catch (Throwable $e) {
        report($e);
        return response()->json(['status' => false]);
    }

    return response()->json(['status' => true]);
});

/* Change customer profile */

Route::middleware('guest:api')->post('/change_mechanicdetails', function (Request $request) {

    $request->validate([
        'garage_photo_path1' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        'garage_photo_path2' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        'garage_photo_path3' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        'garage_photo_path4' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
    ]);
    
    for ($x = 1; $x <= 4; $x++) {
        $requestfile = 'garage_photo_path'. $x;
        if($request->hasFile($requestfile)){
            ${'mechanic_pic' . $x . 'name'} = time(). rand(1000,2000) .'.'.$request->$requestfile->extension();
            $request->$requestfile->move(public_path('images'), ${'mechanic_pic' . $x . 'name'});

        }
    }

    try {
        $mechanic = Mechanic::where('id', $request->input('mechanic_id'))->first();
        $mechanic->name = $request->input('name');
        $mechanic->address = $request->input('address');
        $mechanic->phone = $request->input('phone');
        $mechanic->services = $request->input('services');
        $mechanic->servicedescription = $request->input('servicedetails');

        for ($x = 1; $x <= 4; $x++) {
            $requestfile = 'garage_photo_path'. $x;
            if($request->hasFile($requestfile)){
                $mechanic->$requestfile = ${'mechanic_pic' . $x . 'name'};
            }
        }


        $mechanic->save();
    } catch (Throwable $e) {
        var_dump($e);
        die();
        return response()->json(['status' => false]);
    }

    return response()->json(['status' => true]);
});

/* Change customer profile

Route::middleware('guest:api')->post('/deleteimge', function (Request $request) {

    try {
        $customer = Customer::where('id', $request->input('customer_id'))->first();
        $customer->name = $request->input('name');
        $customer->address = $request->input('address');
        $customer->phone = $request->input('phone');
        $customer->save();
    } catch (Throwable $e) {
        report($e);
        return response()->json(['status' => false]);
    }

    return response()->json(['status' => true]);
});
 */

/* Change customer profile */

Route::middleware('guest:api')->get('/deleteimage/{image_no}/{mechanic_id}', function ($image_no, $mechanic_id) {

    try {
        $mechanic = Mechanic::where('id', $mechanic_id)->first();
        $mechanic->{'garage_photo_path' . $image_no} = NULL;
        $mechanic->save();
    } catch (Throwable $e) {
        report($e);
        return response()->json(['status' => false]);
    }

    return response()->json(['status' => true]);
});


/* Change customer profile */