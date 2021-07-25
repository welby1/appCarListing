<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\SearchDataResource;

use App\Models\Car;

class HomeController extends Controller
{
    public function index(){
        $data = Car::all();
        return SearchDataResource::collection($data);
    }

    public function loadModels(Request $request){
        return Car::where('make', $request->make)->get();
    }

    public function searchCars(Request $request){
        $make = $request->make;
        $model = $request->model;
        $year = $request->year;

        $data = Car::select()
            ->when($make, function($q) use ($make){
                return $q->where('make', '=', $make);
            })
            ->when($model, function($q) use ($model){
                return $q->where('model', '=', $model);
            })
            ->when($year, function($q) use ($year){
                return $q->where('year', '=', $year);
            })
            ->paginate(9);
        return $data;
    }
}