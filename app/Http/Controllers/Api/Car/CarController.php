<?php

namespace App\Http\Controllers\Api\Car;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CarResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Car;
use App\Events\CarCreated;

class CarController extends Controller
{
    public function getFilters()
    {
        $bodies = Car::distinct()->get('body_type');
        $fuels = Car::distinct()->get('fuel_type');
        $transmissions = Car::distinct()->get('transmission_type');

        $response = [
            'body' => $bodies,
            'fuel' => $fuels,
            'transmission' => $transmissions
        ];

        return response()->json($response);
    }

   
    public function loadCars(Request $request)
    {
        $body = $request->body;
        $fuel = $request->fuel;
        $transmission = $request->transmission;

        return Car::select()
            ->when(count($body), function($q) use ($body){
                return $q->whereIn('body_type', $body);
            })
            ->when(count($fuel), function($q) use ($fuel){
                return $q->whereIn('fuel_type', $fuel);
            })
            ->when(count($transmission), function($q) use ($transmission){
                return $q->whereIn('transmission_type', $transmission);
            })
            ->orderBy('created_at', 'DESC')->paginate(9);
    }
    
    public function index(){
        $id = Auth::id();
        return Car::where('user_id', '=', $id)->get();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'make' => ['required', 'string'],
            'model' => ['required', 'string'],
            'year' => ['required', 'digits:4'],
            'body_type' => ['required', 'string', 'max:50'],
            'fuel_type' => ['required', 'string', 'max:50'],
            'engine_displ' => ['required', 'integer'],
            'transmission_type' => ['required', 'string', 'max:50'],
            'price' => ['required', 'numeric'],
            'description' => ['required', 'string', 'max:255']
        ]);

        Car::create([
            'make' => $request->make,
            'model' => $request->model,
            'year' => $request->year,
            'body_type' => $request->body_type,
            'fuel_type' => $request->fuel_type,
            'engine_displ' => $request->engine_displ,
            'transmission_type' => $request->transmission_type,
            'price' => $request->price,
            'description' => $request->description,
            'user_id' => Auth::id()
        ]);

        event(new CarCreated('Event: car created'));

        return 'successfull created';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Car::with(['photos','user'])->where('id','=', $id)->get();
        return CarResource::collection($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
