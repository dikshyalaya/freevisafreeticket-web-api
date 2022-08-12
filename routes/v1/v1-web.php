<?php

use App\Http\Controllers\Admin\Location\LocationAjaxController;
use App\Http\Controllers\ApplicantFilterController;
use App\Http\Controllers\Candidates\AuthController as CanidateAuthController;
use App\Http\Controllers\Candidates\DashController;
use App\Http\Controllers\Company\NewApplicantController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\JobsController;
use App\Http\Controllers\Site\NewsController;
use App\Http\Controllers\Site\PageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    require_once 'web/admin.php';
});
Route::prefix('candidate')->group(function () {
    require_once 'web/candidate.php';
});
Route::prefix('company')->group(function () {
    require_once 'web/company.php';
});
Route::get('candidate/{name?}', [CanidateAuthController::class, 'login'])->name('candidate.login')->middleware('guest');
// Auth
Auth::routes();
// Site Routes
Route::get('/', [HomeController::class, 'home']);
Route::get('/mark-as-read/{id}', [HomeController::class, 'markRead'])->name('markread');
Route::get('/companies', [HomeController::class, 'companies'])->name('site.companies');
// Route::get('/company-view/{id}', [HomeController::class, 'company'])->middleware('viewCompanyDetail');
Route::get('/company-view/{id}', [HomeController::class, 'company'])->name('site.companydetail');
Route::get('jobs/', [JobsController::class, 'index'])->name('site.jobs');
Route::get('job/{id}', [JobsController::class, 'jobindex'])->name('viewJob');
Route::post('store-job-view', [JobsController::class, 'storeJobView'])->name('storeJobView');
Route::get('news/', [NewsController::class, 'index'])->name('news.index');
Route::get('news/{slug}', [NewsController::class, 'getNews'])->name('news.details');
Route::get('page/{slug}', [PageController::class, 'index'])->name('viewPage');

Route::post('get-job-by-title', [HomeController::class, 'getJobsByTitle'])->name('getJobsByTitle');

Route::middleware(['auth'])->group(function () {
    Route::get('/apply-job/{id}', [DashController::class, 'applyjob'])->name('applyForJob');
    Route::get('/remove-application/{id}', [DashController::class, 'removeApplication']);
});

Route::prefix('ajax')->group(function () {
    Route::post('/countries', [LocationAjaxController::class, 'countries']);
    Route::post('/states', [LocationAjaxController::class, 'states']);
    Route::post('/cities', [LocationAjaxController::class, 'cities']);
    Route::post('/districts', [LocationAjaxController::class, 'districts'])->name('getAjaxDistricts');
});

Route::put('bulk-application-status-update', [NewApplicantController::class, "bulkUpdateApplicationStatus"])->name("bulkUpdateApplicationStatus");
Route::get('bulk-cv-download', [NewApplicantController::class, "bulkCvDownload"])->name("bulkCvDownload");
Route::delete('bulk-application-delete', [NewApplicantController::class, "bulkApplicationDelete"])->name("bulkApplicationDelete");
Route::match(['GET', 'POST'], 'save-applicant-filter', [ApplicantFilterController::class, 'saveFilter'])->name('saveFilter');
Route::get('get-applicant-filter', [ApplicantFilterController::class, "getApplicantFilter"])->name("getApplicantFilter");
Route::post('bulk-schedule-interview', [NewApplicantController::class, "bulkScheduleInterview"])->name("bulkScheduleInterview");
Route::get('get-advaced-search', [ApplicantFilterController::class, "getAdvancedSearchData"])->name("getAdvancedSearchData");
