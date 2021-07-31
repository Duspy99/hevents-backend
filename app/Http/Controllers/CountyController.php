<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\County;  

class CountyController extends Controller
{
    public function postCounty(Request $request)
    {
        
        $validate = $this->validate($request, [
            'name' => 'required|unique:counties',
            'zip' => 'required|unique:counties',
        ]);
        
        $county = new County;
        $county->name = $request->name;
        $county->zip = $request->zip;
        $county->save();

        return response()->json(['success' => 'County created'], 201);
    }

    public function getCounties()
    {
        return County::all();
    }
    
    public function getCounty(Request $request)
    {
        return County::where('zip',$request->id)->firstOrFail();
    }
}
