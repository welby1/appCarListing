<?php

namespace App\Http\Controllers\Api\Car;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
