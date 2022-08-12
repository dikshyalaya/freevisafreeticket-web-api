<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Ajax\AddController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('lang/{locale?}', function($locale = null){
    if(isset($locale) && in_array($locale, array_keys(config('app.available_locales')))){
        app()->setLocale($locale);
        session()->put('locale', $locale);
    }
    return redirect()->back();

});
Route::group(['prefix' => 'skill/', 'as' => 'admin.skill.'], function(){
    Route::post('ajax-store-skill', [AddController::class, "ajaxStoreSKill"])->name("ajaxAddSkill");
});
Route::group(['prefix' => 'training/', 'as' => 'admin.training.'], function(){
    Route::post('ajax-store-training', [AddController::class, "ajaxStoreTraining"])->name("ajaxAddTraining");
});
require_once 'v1/v1-web.php';

//NOTIFICATION
Route::get('/notifications-read/{type}/{id}', [\App\Http\Controllers\Site\HomeController::class, "readNotifications"])->name('site.read-notifications');
