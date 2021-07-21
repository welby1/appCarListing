<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'img_path',
        'car_id',
    ];

    public function car(){
        return $this->belongsTo(Car::class);
    }
}
