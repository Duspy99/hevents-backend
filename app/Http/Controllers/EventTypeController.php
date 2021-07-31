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

}
