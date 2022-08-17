<?php

use App\Http\Controllers\API\ApiMethodsController;
use App\Http\Controllers\API\Location\LocationV2Controller;
use Illuminate\Support\Facades\Route;

// Route::prefix('admin')->group(function(){
//     require_once 'api/admin.php';
// });
// Route::prefix('candidate')->group(function(){
//     require_once 'api/candidate.php';
// });
// Route::prefix('company')->group(function(){
//     require_once 'api/company.php';
// });

Route::get("countries", [LocationV2Controller::class, 'countries']);
Route::get("states", [LocationV2Controller::class, 'states']);
Route::get("cities", [LocationV2Controller::class, 'cities']);
Route::get("metadata", [ApiMethodsController::class, 'metData']);
