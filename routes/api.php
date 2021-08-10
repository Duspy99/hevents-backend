<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CountyController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ObjectController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//login register/////////////////////////////////

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);

/////////////////////////////////////////////////

//public api's get //////////////////////////////

//objects

Route::get('objects', [ObjectController::class, 'getObjects']);
Route::get('objects/{id}', [ObjectController::class, 'getObject']);

//events

Route::get('events', [EventController::class, 'getEvents']);
Route::get('events/{id}', [EventController::class, 'getEvent']);
Route::get('events-in', [EventController::class, 'getEventsIn']);
Route::get('events-out', [EventController::class, 'getEventsOut']);
Route::get('all-event-types',[EventTypeController::class,'getAllEventTypes']);
Route::get('event-types',[EventTypeController::class,'getEventTypes']);
Route::get('object-types',[EventTypeController::class,'getObjectTypes']);


////////////////////////////////////////////////

//cities,counties

Route::get('counties', [CountyController::class, 'getCounties']);
Route::get('counties/{id}', [CountyController::class, 'getCounty']);
Route::get('cities', [CityController::class, 'getCities']);
Route::get('cities/{id}', [CityController::class, 'getCity']);


//admin/////////////////////////////////////////

Route::middleware('admin')->group(function () {

    //work with users

    Route::get('users', [UserController::class, 'getUsers']);
    Route::get('users/{id}', [UserController::class, 'getUser']);
    Route::get('moderators', [UserController::class, 'getModerators']);
    Route::get('administrators', [UserController::class, 'getAdministrators']);
    Route::patch('users/{id}',[UserController::class, 'editUser']);

    //work with counties

    Route::post('county', [CountyController::class, 'postCounty']);

    //work with cities

    Route::post('city', [CityController::class, 'postCity']);

    //work with event types

    Route::post('event-type', [EventTypeController::class, 'postEventType']);

    //work with objects


    //work with events

  

});

////////////////////////////////////////////////

//moderator/////////////////////////////////////

Route::middleware('moderator')->group(function () {

    //work with objects

    Route::post('object', [ObjectController::class, 'postObject']);
    Route::delete('objects/{id}', [ObjectController::class, 'deleteObject']);
    Route::patch('objects/{id}', [ObjectController::class, 'editObject']);
    Route::get('my-objects', [ObjectController::class, 'getMyObjects']);
  

    //work with events

    Route::post('event', [EventController::class, 'postEvent']);
    Route::delete('events/{id}', [EventController::class, 'deleteEvent']);
    Route::patch('events/{id}', [EventController::class, 'editEvent']);
    Route::get('my-events', [EventController::class, 'getMyEvents']);
    
    
});

////////////////////////////////////////////////






Route::middleware('auth:api')->group(function () {

    Route::get('me', [UserController::class, 'getMe']);

});