<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Company\JobController;
use App\Http\Controllers\Company\AuthController;
use App\Http\Controllers\Company\DashController;
use App\Http\Controllers\Company\JobsController;
use App\Http\Controllers\Company\NewJobController;
use App\Http\Controllers\ApplicantFilterController;
use App\Http\Controllers\Company\ApplicantController;
use App\Http\Controllers\Company\NewApplicantController;

Route::get('/login', [AuthController::class, 'login'])->name('company.login');
Route::post('/register', [AuthController::class, 'register'])->name('company.register');
Route::middleware(['auth', 'is_company'])->group(function () {
    Route::get('/', [DashController::class, 'dashboard'])->name('company.dash');
    Route::get('/profile', [DashController::class, 'profile'])->name('company.edit_profile');
    Route::post('/profile', [DashController::class, 'saveProfile'])->name('company.save_profile');
    Route::post('/remove-image', [DashController::class, 'removeImage'])->name('company.remove_image');
    Route::put('/update/{id}', [DashController::class, 'updateProfile'])->name('company.update_profile');
    Route::get('/view-my-profile', [DashController::class, 'show'])->name('company.view_profile');
    Route::get('/notifications', [DashController::class, "getNotifications"])->name('company.get-notifications');

    Route::get('/jobs', [JobsController::class, 'index'])->name('company.jobs');
    // Route::get('/jobs', [DashController::class, 'jobs'])->name('company.jobs');
    // Route::get('/edit/job/{id}', [DashController::class, 'edit'])->name('company.editjob');
    Route::get('/applicants', [DashController::class, 'applicants'])->name('company.applicants');
    Route::get('/settings', [DashController::class, 'settings'])->name('company.settings');
    Route::post('/save-settings', [DashController::class, 'saveSettings'])->name('company.saveSettings');

    Route::get('add-new-job', [JobController::class, "addNewJob"])->name("company.addNewJob");
    Route::post('save-new-job', [JobController::class, "saveNewJob"])->name("company.saveNewJob");
    Route::get('/edit/job/{id}', [JobController::class, 'edit'])->name('company.editjob');
    Route::put('/udpate/job/{id}', [JobController::class, 'updateJob'])->name('company.updateJob');
    Route::post('clone-job/{id}', [JobController::class, 'cloneJob'])->name('company.cloneJob');
    Route::get('view-job/{id}', [JobController::class, 'viewjob'])->name('company.viewjob');

    Route::group(['prefix' => 'applicants/', 'as' => 'company.applicant.'], function () {
        Route::get('', [ApplicantController::class, 'applicants'])->name('index');
        Route::get('applicant-detail/{id}', [ApplicantController::class, 'applicant_detail'])->name('detail');
        Route::get('edit/{id}', [ApplicantController::class, 'edit_application'])->name('editApplication');
        Route::put('update-application/{id}', [ApplicantController::class, 'updateApplication'])->name('updateApplication');

        Route::get('index', [NewApplicantController::class, "index"])->name("indexpage");
        Route::get('advanced-search', [NewApplicantController::class, "advancedSearch"])->name("advancedSearch");
    });

    Route::group(['prefix' => 'job/', 'as' => 'company.newjob.'], function () {
        Route::get('job_detail', [NewJobController::class, "get_job_detail"])->name('get_job_detail');
        Route::post('job_detail', [NewJobController::class, "postJobDetail"])->name('postJobDetail');
        Route::get('get_applicant_form', [NewJobController::class, "get_applicant_form"])->name('get_applicant_form');
        Route::post('post_applicant_form', [NewJobController::class, "post_applicant_form"])->name('post_applicant_form');
        Route::get('get_salary_and_facility_form', [NewJobController::class, "get_salary_and_facility_form"])->name('get_salary_and_facility_form');
        Route::post('post_salary_and_facility_form', [NewJobController::class, "post_salary_and_facility"])->name('post_salary_and_facility');
        Route::get('get_job_preview', [NewJobController::class, "get_job_preview"])->name('get_job_preview');
        Route::get('get_approval', [NewJobController::class, "get_approval_form"])->name('get_approval_form');
        Route::post('post_approval', [NewJobController::class, "post_approval_form"])->name('post_approval_form');
    });

    Route::group(['prefix' => 'web-api'], function () {
        Route::get('getApplicants', [NewApplicantController::class, "getApplicants"]);
        Route::get('getDataSets', [NewApplicantController::class, "getDataSets"]);
        Route::post('bulk-status-update', [NewApplicantController::class, "bulkUpdateApplicationStatus"]);
        Route::post('bulk-cv-download', [NewApplicantController::class, "bulkCvDownload"]);
        Route::delete('bulk-application-delete', [NewApplicantController::class, "bulkApplicationDelete"]);
        Route::post('bulk-interview-schedule', [NewApplicantController::class, "bulkScheduleInterview"]);
        Route::get('get-applicant-filter', [ApplicantFilterController::class, "getApplicantFilter"]);
        Route::post('save-advaced-filter', [ApplicantFilterController::class, "saveFilter"]);
    });

});
