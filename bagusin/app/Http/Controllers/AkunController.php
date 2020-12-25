<?php
namespace App\Http\Controllers;

    use App\Http\Controllers\Controller;
    use App\Models\Customer;
    use App\Models\Mechanic;
    use Illuminate\Http\Request;
    use Validator;
    use Illuminate\Support\Facades\Auth;
    use DB;

    class AkunController extends Controller
    {

        public function show()
        {
            if(Auth::guard('customer')->user() or Auth::guard('mechanic')->user()){
                $pics = [];
                if(Auth::guard('mechanic')->user()){

                    $mechanic = Mechanic::where('id', Auth::guard('mechanic')->user()->id)->first();
                    for($x = 1; $x < 5 ; $x++){
                        array_push($pics, $mechanic->{'garage_photo_path'.$x});

                    }

                }
                
                return view('akun', ['pics' => $pics]);
            }
            return redirect()->route('masuk');
        }

        public function editprofile(Request $request)
        {   
            /* If the action performed by customer */
            if(Auth::guard('customer')->user()){
                $request->validate([
                    'name' => 'bail|required|max:50',
                    'phone' => 'bail|required|numeric|digits_between:10,13',
                    'address' => 'bail|required|max:100',
                ]);
                
                $user_email = Auth::guard('customer')->user()->email;
                $name = $request->input('name');
                $phone = $request->input('phone');
                $address = $request->input('address');
                DB::update('update customers set name = ?, phone = ?, address = ? where email = ?',[$name,$phone,$address,$user_email]);
            
            /* If the action performed by mechanic */
            }else if(Auth::guard('mechanic')->user()){
                $request->validate([
                    'name' => 'bail|required|max:50',
                    'phone' => 'bail|required|numeric|digits_between:10,13',
                    'address' => 'bail|required|max:100',
                    'services' => 'bail|required|max:100',
                    'servicedescription' => 'bail|required|max:190',
                    'mechanicpic1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
                    'mechanicpic2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
                    'mechanicpic3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
                    'mechanicpic4' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',

                ]);
                
                $user_email = Auth::guard('mechanic')->user()->email;
                $name = $request->input('name');
                $phone = $request->input('phone');
                $address = $request->input('address');
                $services = $request->input('services');
                $servicedescription = $request->input('servicedescription');
                $mechanic = Mechanic::where('id', Auth::guard('mechanic')->user()->id)->first();

                for ($x = 1; $x <= 4; $x++) {
                    $requestfile = 'mechanicpic'. $x;
                    if($request->hasFile($requestfile)){
                        ${'mechanicpic' . $x . 'name'} = time(). rand(1000,2000) .'.'.$request->$requestfile->extension();
                        $request->$requestfile->move(public_path('images'), ${'mechanicpic' . $x . 'name'});
                        $mechanic->{'garage_photo_path'. $x} = ${'mechanicpic' . $x . 'name'};
                    }
                }
                $mechanic->save();
                DB::update('update mechanics set name = ?, phone = ?, address = ?, services = ?, servicedescription = ? where email = ?',[$name,$phone,$address,$services, $servicedescription, $user_email]); 
            }
            return redirect()->back()->withInput()->with('message', "Detail akun berhasil diubah!");
        }

    }