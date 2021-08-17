<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = 'events';

    protected $fillable = [
        'name',
        'description',
        'location',
        'city_id',
        'county_id',
        'object_id',
        'user_id',
        'type_id',
        'image_name',
        'date',
        'time',
    ];
}
