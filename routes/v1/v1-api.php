<?php

use App\Http\Controllers\API\ApiMethodsController;
use App\Http\Controllers\API\Candidates\PreferenceController;
use App\Http\Controllers\API\Location\LocationController;
use App\Http\Controllers\API\UsefulInformationController;
use Illuminate\Support\Facades\Route;

use App\Models\UsefulInformation;

Route::prefix('admin')->group(function(){
    require_once 'api/admin.php';
});
Route::prefix('candidate')->group(function(){
    require_once 'api/candidate.php';
});
Route::prefix('company')->group(function(){
    require_once 'api/company.php';
});



Route::get('options/list/{type?}', [PreferenceController::class, 'optionsList']);

Route::get("countries", [LocationController::class, 'countries']);
Route::get("states", [LocationController::class, 'states']);
Route::get("cities", [LocationController::class, 'cities']);
Route::get("metaData", [ApiMethodsController::class, 'metData']);


Route::prefix("info-pages")->group(function(){
    Route::get("/list", [UsefulInformationController::class, 'List']);
    Route::get("{slug}", [UsefulInformationController::class,"GetPage"]);
});
