<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Designation::all();
        return view("pages.designation", compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pages.add-designation");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'designation' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        $make = Designation::create([
            'designation' => $request->designation,
            'status' => $request->status
        ]);


        if ($make) {
            return response()->json(['Data saved successfully']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Designation::where('id', $id)->first();
        return view("pages.edit-designation", compact("data"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'designation' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }
        $id = $request->id;
        $make =  Designation::where('id', $id)->update([  'designation' => $request->designation , 'status' => $request->status]);

        if ($make) {
            return response()->json(['Data Update successfully']);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function changeStatus(Request $request)
    {
        $status = $request->status;
        $id = $request->id;

        if ($status == 1) {
            $val = 0;
            $message = 'Status Changed to Active';
        } elseif ($status == 0) {
            $val = 1;
            $message = 'Status Changed to Inactive';
        }
        $make = Designation::where('id', $id)->update(['status' => $val]);

        if ($make) {
            return response()->json(['message' => $message, 'status' => $val]);
        }
    }
}
