<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $designation_count = Designation::all()->count();
        $total_user = User::all()->count();
        $total_active_user = User::where('status' ,1)->count();
        $total_inactive_user = User::where('status',0)->count();
        return view('home', compact('designation_count','total_user','total_active_user','total_inactive_user'));
    }
}
