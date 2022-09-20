<?php

use App\Http\Controllers\API\ApiMethodsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Location\LocationController;
use App\Http\Controllers\API\UsefulInformationController;

Route::prefix('admin')->group(function(){
    require_once 'api/admin.php';
});
Route::prefix('candidate')->group(function(){
    require_once 'api/candidate.php';
});
Route::prefix('company')->group(function(){
    require_once 'api/company.php';
});

Route::get("countries", [LocationController::class, 'countries']);
Route::get("states", [LocationController::class, 'states']);
Route::get("cities", [LocationController::class, 'cities']);
Route::get("metaData", [ApiMethodsController::class, 'metData']);

Route::get("info-pages/{slug}", [InfoPagesController::class,"get_page_by_slug"]);