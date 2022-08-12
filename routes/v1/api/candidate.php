<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Candidates\AuthController;
use App\Http\Controllers\API\Candidates\ProfileController;
use App\Http\Controllers\API\Candidates\Jobs\JobsListController;
use App\Http\Controllers\API\Candidates\Jobs\JobApplicationController;
use App\Http\Controllers\API\Candidates\Jobs\JobCategoryController;
use App\Http\Controllers\API\Candidates\News\NewsController;
use App\Http\Controllers\API\Candidates\News\NewsCategoryController;
use App\Http\Controllers\API\Candidates\BannerController;
use App\Http\Controllers\API\Candidates\CvController;
use App\Http\Controllers\API\Candidates\PreferenceController;


Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('profile', [ProfileController::class, 'get_profile']);
    Route::post('profile', [ProfileController::class, 'updateProfile']);
    Route::post('job-application', [JobApplicationController::class, 'apply']);
    Route::post('job-application/{id}', [JobApplicationController::class, 'index']);
    Route::post('job-application-list', [JobApplicationController::class, 'list']);
    Route::post('change-password', [ProfileController::class, 'change_password']);

    // CV Upload
    Route::post('/cv', [CvController::class, 'upload'])->name('candidate.cv.upload');
    // Fetch CV
    Route::get('/cv', [CvController::class, 'fetch'])->name('candidate.cv.fetch');
    // Edit CV
    Route::patch('/cv', [CvController::class, 'edit'])->name('candidate.cv.edit');
    // Delete CV
    Route::delete('/cv/{id}', [CvController::class, 'delete'])->name('candidate.cv.delete');
    // Job Preferences
    // employer_job_category
    Route::get('/preference/job-category', [PreferenceController::class, 'get_employes_job_category'])->name('candidate.preference.job_category');
    Route::post('/preference/job-category', [PreferenceController::class, 'add_employes_job_category'])->name('candidate.preference.job-category.add');
    Route::patch('/preference/job-category', [PreferenceController::class, 'update_employes_job_category'])->name('candidate.preference.job-category.update');
    Route::delete('/preference/job-category/{id}', [PreferenceController::class, 'delete_employes_job_category'])->name('candidate.preference.job-category.delete');
    // employer_country
    Route::get('/preference/country', [PreferenceController::class, 'get_employes_country'])->name('candidate.preference.employer_country');
    Route::post('/preference/country', [PreferenceController::class, 'add_employes_country'])->name('candidate.preference.country.add');
    Route::patch('/preference/country', [PreferenceController::class, 'update_employes_country'])->name('candidate.preference.country.update');
    Route::delete('/preference/country/{id}', [PreferenceController::class, 'delete_employes_country'])->name('candidate.preference.country.delete');
});
// Listing
Route::get('job/home', [JobsListController::class, 'getHome']);
Route::get('job-list', [JobsListController::class, 'jobListing']);
Route::get('job-categories', [JobCategoryController::class, 'categoryListing']);

Route::post('job/apply', [JobsListController::class, 'applyJob']);
Route::get('job/apply/list', [JobsListController::class, 'listAppliedJob']);

Route::get('news-categories', [NewsCategoryController::class, 'list']);
Route::get('news', [NewsController::class, 'list']);
Route::get('news/{id}', [NewsController::class, 'index']);

Route::get('banners', [BannerController::class, 'list']);


Route::post('saveJobPreference', [PreferenceController::class, 'saveJobPreference']);
Route::get('getJobPreference', [PreferenceController::class, 'getJobPreference']);
Route::post('removeJobPreference', [PreferenceController::class, 'removeJobPreference']);

