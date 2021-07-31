<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Object_;

class EventController extends Controller
{
    public function postEvent(Request $request)
    {
        $validate = $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'city_id' => 'required',
            'county_id' => 'required',
            'type_id' => 'required',
            'object_id' => 'exists:objects,id'
        ]);

        $event = new Event;
        $event->name = $request->name;
        $event->description = $request->description;
        
        if($request->object_id)
        {
            $object = Object_::where('id',$request->object_id)->firstOrFail();
            $event->location = $object->location;
            $event->city_id = $object->city_id;
            $event->county_id = $object->county_id;
            $event->type_id = $object->type_id;
            $event->object_id = $request->object_id;
        }
        else{
            $event->location = $request->location;
            $event->city_id = $request->city_id;
            $event->county_id = $request->county_id;
            $event->object_id = $request->object_id;
            $event->type_id = $request->type_id;
        }
        
        $event->user_id = auth('api')->user()->id;
        $event->save();

        return response()->json(['success' => 'Event created'], 201);
      
    }

    public function deleteEvent(Request $request)
    {
        $event = Event::where('id',$request->id)->firstOrFail();
        if(auth('api')->user()->id == $event->user_id || auth('api')->user()->role == '99')
        {
            Event::destroy($event->id);
            return response()->json(['success' => 'Event deleted'], 201);
        }
        
        return response()->json(['error' => 'Forbidden.'], 403);

    }

    public function getEvents()
    {
        return Event::all();
    }

    public function getEvent(Request $request)
    {
        return Event::where('id',$request->id)->firstOrFail();
    }

    public function getEventsIn()
    {
        return Event::where('object_id','!=',NULL)->get();
    }

    public function getEventsOut()
    {
        return Event::where('object_id',NULL)->get();
    }

    public function getMyEvents()
    {
        return Event::where('user_id',auth('api')->user()->id)->get();
    }

    public function editEvent(Request $request)
    {
        
        $event = Event::where('id',$request->id)->firstOrFail();
        if(auth('api')->user()->id == $event->user_id || auth('api')->user()->role == '99')
        {

            if($event->object_id)
            {
                $validate = $this->validate($request, [
                    'name' => 'required',
                    'description' => 'required',
                ]);

                $event->update(['name' => $request->name]);
                $event->update(['description' => $request->description]);
                
            }
            
            if(!$event->object_id)
            {
                $validate = $this->validate($request, [
                    'name' => 'required',
                    'description' => 'required',
                    'city_id' => 'required',
                    'county_id' => 'required',
                    'type_id' => 'required',
                ]);

                $event->update(['name' => $request->name]);
                $event->update(['city_id' => $request->city_id]);
                $event->update(['county_id' => $request->county_id]);
                $event->update(['type_id' => $request->type_id]);
                $event->update(['location' => $request->location]);
            }

            return response()->json(['success' => 'Event updated'], 201);
        }

        return response()->json(['error' => 'Forbidden.'], 403); 
    }
}
