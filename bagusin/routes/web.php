<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasukController;
use App\Http\Controllers\MasukMekanikController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\KeluarController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\UbahPasswordController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\CariController;
use App\Http\Controllers\MechanicDetailsController;
use App\Http\Controllers\CallMechanicController;
use App\Http\Controllers\DaftarinMekanikController;
use App\Http\Controllers\MyOrderController;
use App\Http\Controllers\PostReviewController;
use App\Http\Controllers\AdminController;



Use App\Models\Customer;
Use App\Models\Order;
Use App\Models\Mechanic;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [IndexController::class, 'show'])->name('home');

/* Login */

Route::get('/masuk', [MasukController::class, 'show'])->middleware('guest')->name('masuk');

Route::post('/masuk', [MasukController::class, 'masuk'])->middleware('guest')->name('masuk');


/* Login */

Route::get('/masuk_mekanik', [MasukMekanikController::class, 'show'])->middleware('guest')->name('masukmekanik');

Route::post('/masuk_mekanik', [MasukMekanikController::class, 'masuk'])->middleware('guest')->name('masukmekanik');

/* Logout */

Route::get('/keluar', [KeluarController::class, 'keluar'])->name('keluar');


/* Customer Register */

Route::get('/daftar', [DaftarController::class, 'show'])->middleware('guest')->name('daftar');

Route::post('/daftar', [DaftarController::class, 'daftar'])->middleware('guest')->name('daftar');

/* Mechanic Register */

Route::get('/daftar_mekanik', [DaftarinMekanikController::class, 'show'])->middleware('guest')->name('daftarmekanik');

Route::post('/daftar_mekanik', [DaftarinMekanikController::class, 'daftarmekanik'])->middleware('guest')->name('daftarmekanik');

/* Account */

Route::get('/akun', [AkunController::class, 'show'])->middleware('guest')->name('akun');

Route::post('/akun', [AkunController::class, 'editprofile'])->middleware('guest')->name('akun');

/* Change Password */

Route::get('/ubahpassword', [UbahPasswordController::class, 'show'])->middleware('guest')->name('ubahpassword');

Route::post('/ubahpassword', [UbahPasswordController::class, 'changepassword'])->middleware('guest')->name('ubahpassword');

/* History */

Route::get('/riwayat', [RiwayatController::class, 'show'])->middleware('guest')->name('riwayat');

/* Search */

Route::get('/search', [CariController::class, 'show'])->middleware('guest')->name('cari');

/* Mechanic Details */

Route::get('/mechanicdetails/{id}', [MechanicDetailsController::class, 'show'])->middleware('guest')->name('mechanicdetails');

/* Call Mechanic */

Route::get('/callmechanic/{id}', [CallMechanicController::class, 'show'])->middleware('guest')->name('callmechanic');

Route::post('/callmechanic/{id}', [CallMechanicController::class, 'callmechanic'])->middleware('guest')->name('callmechanic');

/* Current Order */

Route::get('/myorder', [MyOrderController::class, 'show'])->middleware('guest')->name('currentorder');


/* Current Order */

Route::post('/postreview/{id}', [PostReviewController::class, 'postreview'])->middleware('guest')->name('postreview');

/* Accept Order */

Route::get('accept/{id}', function ($id) {
    $order = Order::where('id', $id)->first();
    if($order->mechanic_id != Auth::guard('mechanic')->user()->id){
        return response()->json(['message' => 'Error.'], 403);
    }

    $order->status = 'accept';
    $order->save();

    return response()->json(['message' => 'success'], 200);
});

/* Reject Order */

Route::get('reject/{id}', function ($id) {
    $order = Order::where('id', $id)->first();
    if($order->mechanic_id != Auth::guard('mechanic')->user()->id){
        return response()->json(['message' => 'Error.'], 403);
    }
    $mechanic = Mechanic::where('id', $order->mechanic_id)->first();
    $mechanic->hasorder = 0;
    $mechanic->save();
    $order->status = 'reject';
    $order->save();

    return response()->json(['message' => 'success'], 200);
});

/* Finish Order */

Route::get('finish/{id}', function ($id) {
    $order = Order::where('id', $id)->first();
    if($order->mechanic_id != Auth::guard('mechanic')->user()->id){
        return response()->json(['message' => 'Error.'], 403);
    }
    $mechanic = Mechanic::where('id', $order->mechanic_id)->first();
    $mechanic->hasorder = 0;
    $mechanic->save();
    $order->status = 'done';
    $order->save();

    return response()->json(['message' => 'success'], 200);
});


/* Cancel Order */

Route::get('cancel/{id}', function ($id) {
    $order = Order::where('id', $id)->first();
    if($order->customer_id != Auth::guard('customer')->user()->id){
        return response()->json(['message' => 'Error.'], 403);
    }
    $mechanic = Mechanic::where('id', $order->mechanic_id)->first();
    $mechanic->hasorder = 0;
    $mechanic->save();
    $order->status = 'cancel';
    $order->save();

    return response()->json(['message' => 'success'], 200);
});

/* Count undone order */

Route::get('/countorders', function(){
    if(Auth::guard('customer')->user()){
        $order = Order::where('customer_id', Auth::guard('customer')->user()->id)
        ->where('status', '=', 'waiting')
        ->orWhere('status', '=', 'done')
        ->latest('created_at')
        ->first();

        if($order->customer_rating != NULL){
            $order = null;
        }

        return response()->json(['order' => $order]);
    }else if(Auth::guard('mechanic')->user()){
        $order = Order::where('mechanic_id', Auth::guard('mechanic')->user()->id)
        ->where('status', '=', 'waiting')
        ->orWhere('status', '=', 'accept')
        ->latest('created_at')
        ->first();
        return response()->json(['order' => $order]);
    }
});

/* Admin */

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->middleware('guest')->name('admindashboard');

Route::get('/admin/login', [AdminController::class, 'showLogin'])->middleware('guest')->name('adminlogin');

Route::post('/admin/login', [AdminController::class, 'doLogin'])->middleware('guest')->name('adminlogin');


Route::get('/admin/customers', [AdminController::class, 'showCustomers'])->middleware('guest')->name('admincustomers');

Route::get('/admin/mechanics', [AdminController::class, 'showMechanics'])->middleware('guest')->name('adminmechanics');

Route::get('/admin/orders', [AdminController::class, 'showOrders'])->middleware('guest')->name('adminorders');


Route::get('/admin/deletecustomer/{id}', function($id){
    if(!Auth::guard('admin')->user()){
        return response()->json(['message' => 'Error'], 403);
    }
    $order = Order::where('customer_id', $id)->delete();
    $customer = Customer::where('id', $id)->delete();

    return response()->json(['message' => 'success'], 200);
});

Route::get('/admin/detailcustomer/{id}', function($id){
    if(!Auth::guard('admin')->user()){
        return response()->json(['message' => 'Error'], 403);
    }

    $customer = Customer::where('id', $id)->first();

    return response()->json(['customer' => $customer], 200);
});


Route::get('/admin/deletemechanic/{id}', function($id){
    if(!Auth::guard('admin')->user()){
        return response()->json(['message' => 'Error'], 403);
    }
    $order = Order::where('mechanic_id', $id)->delete();
    $mechanic = Mechanic::where('id', $id)->delete();

    return response()->json(['message' => 'success'], 200);
});

Route::get('/admin/detailmechanic/{id}', function($id){
    if(!Auth::guard('admin')->user()){
        return response()->json(['message' => 'Error'], 403);
    }

    $mechanic = Mechanic::where('id', $id)->first();

    return response()->json(['mechanic' => $mechanic], 200);
});


Route::get('/admin/detailorder/{id}', function($id){
    if(!Auth::guard('admin')->user()){
        return response()->json(['message' => 'Error'], 403);
    }

    $order = Order::where('id', $id)->first();
    $mechanic = Mechanic::where('id', $order->mechanic_id)->first();
    $customer = Customer::where('id', $order->customer_id)->first();
    $order["customer_name"] = $customer->name;
    $order["mechanic_name"] = $mechanic->name;
    return response()->json(['order' => $order], 200);
});

Route::get('/admin/logout', function(Request $request){
    $request->session()->invalidate();
    return redirect('/admin/login');
});



