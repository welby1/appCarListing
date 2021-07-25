<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Car;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/authenticated', function () {
    return true;
});

Route::post('register', [App\Http\Controllers\Api\Auth\RegisterController::class, 'register']);
Route::post('login', [App\Http\Controllers\Api\Auth\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Api\Auth\LoginController::class, 'logout']);

Route::get('dropdown-data', [App\Http\Controllers\Api\HomeController::class, 'index']);
Route::post('search-cars', [App\Http\Controllers\Api\HomeController::class, 'searchCars']);
Route::post('load-models', [App\Http\Controllers\Api\HomeController::class, 'loadModels']);
Route::get('latest-deals', function (){
    return Car::with('photos')->orderBy('created_at', 'DESC')->take(4)->get();
});

Route::get('get-filters', [App\Http\Controllers\Api\Car\CarController::class, 'getFilters']);
Route::post('cars', [App\Http\Controllers\Api\Car\CarController::class, 'index']);