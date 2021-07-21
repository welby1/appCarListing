<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'make',
        'model',
        'year',
        'body_type',
        'fuel_type',
        'engine_displ',
        'transmission_type',
        'price',
        'description',
        'user_id'
    ];

    public function photos(){
        return $this->hasMany(Photo::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
