<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Object_;
use App\Models\Event;

class ObjectController extends Controller
{
    public function postObject(Request $request)
    {
        $validate = $this->validate($request, [
            'name' => 'required',
            'city_id' => 'required',
            'county_id' => 'required',
            'type_id' => 'required',
        ]);

        $object = new Object_;
        $object->name = $request->name;
        $object->city_id = $request->city_id;
        $object->county_id = $request->county_id;
        $object->type_id = $request->type_id;
        $object->location = $request->location;
        $object->user_id = auth('api')->user()->id;
        $object->save();

        return response()->json(['success' => 'Object created'], 201);
    }

    public function deleteObject(Request $request)
    {
        $object = Object_::where('id',$request->id)->firstOrFail();
        if(auth('api')->user()->id == $object->user_id || auth('api')->user()->role == '99')
        {
            Object_::destroy($object->id);
            return response()->json(['success' => 'Object deleted'], 201);
        }

        return response()->json(['error' => 'Forbidden.'], 403);

    }

    public function getObjects()
    {
        return Object_::all();
    }

    public function getObject(Request $request)
    {
        return Object_::where('id',$request->id)->firstOrFail();
    }

    public function getMyObjects()
    {
        return Object_::where('user_id',auth('api')->user()->id)->get();
    }

    public function editObject(Request $request)
    {
        
        $object = Object_::where('id',$request->id)->firstOrFail();
        if(auth('api')->user()->id == $object->user_id || auth('api')->user()->role == '99')
        {

            $validate = $this->validate($request, [
                'name' => 'required',
                'city_id' => 'required',
                'county_id' => 'required',
                'type_id' => 'required',
            ]);
            
            $object->update(['name' => $request->name]);
            $object->update(['city_id' => $request->city_id]);
            $object->update(['county_id' => $request->county_id]);
            $object->update(['type_id' => $request->type_id]);
            $object->update(['location' => $request->location]);

            $events = Event::where('object_id',$object->id)->get();

            if($events)
            {
                
                foreach($events as $event)
                {
                    $event->update(['type_id' => $object->type_id]);
                    $event->update(['city_id' => $object->city_id]);
                    $event->update(['county_id' => $object->county_id]);
                    $event->update(['location' => $object->location]);
                    
                }
            }

            return response()->json(['success' => 'Object updated'], 201);
        }

        return response()->json(['error' => 'Forbidden.'], 403); 
    }

}
