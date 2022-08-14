<?php

use App\Http\Controllers\API\ApiMethodsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Location\LocationV2Controller;


Route::group(["prefix" => "v2"], function () {

    Route::get("countries", [LocationV2Controller::class, 'countries']);
    Route::get("states", [LocationV2Controller::class, 'states']);
    Route::get("cities", [LocationController::class, 'cities']);
    Route::get("metadata", [ApiMethodsController::class, 'MetData']);

});



// Route::group(["prefix" => "details"], function () {
//     Route::get("country/{id}", [LocationV2Controller::class, 'country_detail']
//     );
// });