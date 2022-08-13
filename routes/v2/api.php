<?php

use App\Http\Controllers\API\ApiMethodsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Location\LocationV2Controller;


Route::get("countries", [LocationV2Controller::class, 'countries']);
Route::get("states", [LocationV2Controller::class, 'states']);
Route::get("cities", [LocationV2Controller::class, 'cities']);
// Route::get("metaData", [ApiMethodsController::class, 'metData']);
