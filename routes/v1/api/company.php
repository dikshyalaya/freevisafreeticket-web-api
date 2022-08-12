<?php

use Illuminate\Support\Facades\Route;

Route::get('list', [\App\Http\Controllers\API\Company\ApiController::class, 'listing']);
Route::get('{company_id}', [\App\Http\Controllers\API\Company\ApiController::class, 'display']);
