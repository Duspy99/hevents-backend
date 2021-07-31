<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Object_ extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'objects';

    protected $fillable = [
        'name',
        'city_id',
        'county_id',
        'type_id',
        'location',
        'user_id'
    ];
}
