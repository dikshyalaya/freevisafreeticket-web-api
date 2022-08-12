<?php

use App\Http\Controllers\API\ApiMethodsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Location\LocationV2Controller;


Route::get("countries", [LocationV2Controller::class, 'countries']);
// Route::get("states", [LocationController::class, 'states']);
// Route::get("cities", [LocationController::class, 'cities']);
// Route::get("metaData", [ApiMethodsController::class, 'metData']);
