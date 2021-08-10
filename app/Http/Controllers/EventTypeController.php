<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventType;

class EventTypeController extends Controller
{

    public function postEventType(Request $request)
    {
          
        $validate = $this->validate($request, [
            'name' => 'required|unique:event_types',
        ]);
        
        $event_type = new EventType;
        $event_type->name = $request->name;

        if($request->isObject)
        {
            $event_type->isObject = $request->isObject;
        }
       
        $event_type->save();

        return response()->json(['success' => 'Event type created'], 201);
    }

    public function getAllEventTypes()
    {
        return EventType::all();
    }

    public function getAllEventType(Request $request)
    {
        return EventType::where('name',$request->id)->firstOrFail();
    }

    public function getObjectTypes()
    {
        return EventType::where('isObject',true)->get();
    }

    public function getObjectType(Request $request)
    {
        return EventType::where('isObject',true)->where('name',$request->id)->firstOrFail();
    }

    public function getEventTypes()
    {
        return EventType::where('isObject', '!=' , true)->orWhereNull('isObject')->get();
    }

    public function getEventType(Request $request)
    {
        return EventType::where('isObject','!=',true)->orWhereNull('isObject')->where('name',$request->id)->firstOrFail();
    }

}
