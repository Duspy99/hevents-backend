<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;  
class CityController extends Controller
{
    public function postCity(Request $request)
    {
        
        $validate = $this->validate($request, [
            'name' => 'required|unique:cities',
            'county_id' => 'required|exists:counties,id',
        ]);
        
        $city = new City;
        $city->name = $request->name;
        $city->county_id = $request->county_id;
        $city->save();

        return response()->json(['success' => 'City created'], 201);
    }

    public function getCities()
    {
        return City::all();
    }
    
    public function getCity(Request $request)
    {
        return City::where('name',$request->id)->firstOrFail();
    }
}
