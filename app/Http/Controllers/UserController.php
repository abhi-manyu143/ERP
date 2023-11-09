<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function home(){
        $user_count = User::count();
        return view('welcome', compact('user_count'));
    }
    public function index(Request $request)
    {
        $user_arr = [];
        $arr = [];
        if($request->filter == 'Designation'){
            $data = User::where('designation_id', $request->id)->get();
        }else if($request->filter == 'Price'){
            $data = User::where('status', $request->id)->get();
        }else{
            $data = User::all();
        }

        if($data == null){
            $data = User::all();
        }
        $designation = Designation::all();

        foreach ($data as  $value) {
            if($value->status == 1){
                $status = 'Active';
            } else if($value->status == 0){
                $status = 'Inactive';
            } else {
                $status ='Super Admin';
            }
            foreach ($designation as $k) {
                if( $value->designation_id == $k->id ){
                    $arr[$k->id] = $k->designation;
                }
                $arr['super_admin'] = 'Super Admin';
            }
            $user_arr[] = [
            'id' => $value->id,
            'name' => $value->name,
            'email' => $value->email,
            'address' => $value->address,
            'status' => $status,
            'designation' => $arr[$value->designation_id]

            ];

        }
        // dd($user_arr);
        if(request()->has('filter')) {
            return response()->json($user_arr);
        }
        return view("pages.list_user", compact('user_arr' , 'designation'));
    }

    public function create_user() {
        $designation = Designation::all();
        return view("pages.create_user",compact("designation"));
    }

    public function store_user(Request $request) {
        // dd($request->all());
        if(Auth::user()->designation_id == 'super_admin')
        {
            $validator = Validator::make($request->all(), [
                'designation' =>  'required',
                'status' =>  'required',
                'email'=>  'required',
                'user_name'=>  'required',
                'address'=> 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()->all()
                ]);
            }


            return User::create([
                'name' => $request['user_name'],
                'email' => $request['email'],
                'address' => $request['address'],
                'designation_id' => $request->designation,
                'status' => $request->status,
                'password' => Hash::make($request['password']),
            ]);
        } else {
            return response()->json([
                'error' => 'Permisson Denied....!'
            ]);
        }


    }
     public function edit_user($id)
     {
        $edit_user = User::find($id);
        $designation = Designation::all();

        return view('pages.edit_user', compact('edit_user','designation'));
     }

     public function store_editUser(Request $request)
     {
        if(Auth::user()->designation_id == 'super_admin')
        {
            $validator = Validator::make($request->all(), [
                'designation' =>  'required',
                'status' =>  'required',
                'email'=>  'required',
                'user_name'=>  'required',
                'address'=> 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()->all()
                ]);
            }


            return User::where('id' , $request->user_id)->update([
                'name' => $request['user_name'],
                'email' => $request['email'],
                'address' => $request['address'],
                'designation_id' => $request->designation,
                'status' => $request->status,
                'password' => Hash::make($request['password']),
            ]);
        } else {
            return response()->json([
                'error' => 'Permisson Denied....!'
            ]);
        }
     }
}
