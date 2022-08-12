<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Candidates\AuthController;
use App\Http\Controllers\Candidates\DashController;
use App\Http\Controllers\Candidates\JobController;

Route::get('/login', [AuthController::class, 'login'])->name('candidate.login');
Route::post('/register', [AuthController::class, 'register'])->name('candidate.register');
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashController::class, 'dashboard'])->name('candidate.dashboard');
    Route::get('/jobs', [DashController::class, 'jobs'])->name('candidate.jobs');
    Route::get('/profile', [DashController::class, 'profile'])->name('candidate.profile');
    Route::get('/show/{id}', [DashController::class, 'show'])->name('candidate.profile.show');
    Route::get('/safty-tips', [DashController::class, 'safty-tips'])->name('candidate.safty-tips');
    Route::get('settings', [DashController::class, 'settings'])->name('candidate.settings');
    Route::get('job-preferences', [DashController::class, 'job_preferences'])->name('candidate.job-preferences');

    // Save Profile
    Route::post('/profile', [DashController::class, 'saveProfile'])->name('candidate.save-profile');
    Route::post('/job-preferences', [DashController::class, 'saveJobPreferences'])->name('candidate.save-job-preferences');
    Route::post('/settings', [DashController::class, 'saveSettings'])->name('candidate.save-settings');

    Route::put('/update-profile/{id}', [DashController::class, 'update'])->name('candidate.updateProfile');

    Route::group(['prefix' => 'company/', 'as' => 'candidate.'], function(){
        Route::get('lists', [DashController::class, 'company_lists'])->name('company_lists');
    });

    Route::group(['prefix' => 'saved-jobs/', 'as' => 'candidate.savedjob.'], function(){
        Route::get('lists', [JobController::class, 'saveJobLists'])->name('saveJobLists');
        Route::post('store', [JobController::class, 'saveJob'])->name('saveJob');
        Route::get('delete/{id}', [JobController::class, 'delete'])->name('delete');
    });

    Route::group(['prefix' => 'recommended-job/', 'as' => 'candidate.'], function(){
        Route::get('', [JobController::class, 'recommended_job'])->name('recommended_job');
    });
});
