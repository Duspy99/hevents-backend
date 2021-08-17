<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Object_;
use Storage;

class EventController extends Controller
{
    public function postEvent(Request $request)
    {
        $event = new Event;
        $event->user_id = auth('api')->user()->id;
        $event->name = $request->name;
        $event->description = $request->description;
        
        if($request->isObject == true)
        {
            $validate = $this->validate($request, [
                'name' => 'required',
                'description' => 'required',
                'object_id' => 'exists:objects,id',
                'date' => 'required',
                'time' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            ]);

            $object = Object_::where('id',$request->object_id)->firstOrFail();
            $event->location = $object->location;
            $event->city_id = $object->city_id;
            $event->county_id = $object->county_id;
            $event->type_id = $object->type_id;
            $event->object_id = $request->object_id;
            
        }
        else{
            $validate = $this->validate($request, [
                'name' => 'required',
                'description' => 'required',
                'city_id' => 'required|exists:cities,id',
                'county_id' => 'required|exists:counties,id',
                'type_id' => 'required|exists:event_types,id',
                'date' => 'required',
                'time' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            ]);

            $event->location = $request->location;
            $event->city_id = $request->city_id;
            $event->county_id = $request->county_id;
            $event->object_id = NULL;
            $event->type_id = $request->type_id;
        }

        $event->date = $request->date;
        $event->time = $request->time;

        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalName();
            Storage::putFileAs('public/images',$image,$image_name);
            $event->image_name = $image_name;
        }
      

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
