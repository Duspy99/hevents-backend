<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'counties';
    
    protected $fillable = [
        'name',
        'zip'
    ];
}
