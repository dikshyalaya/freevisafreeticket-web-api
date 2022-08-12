<?php

use App\Http\Controllers\Candidates\AuthController;
use App\Http\Controllers\Candidates\DashController;
use App\Http\Controllers\Candidates\JobApplicationController;
use App\Http\Controllers\Candidates\JobController;
use App\Http\Controllers\Candidates\JobSearchController;
use App\Http\Controllers\Candidates\JobSettingController;
use App\Http\Controllers\Candidates\NewsController;
use App\Http\Controllers\Candidates\ProfileController;
use App\Http\Controllers\Candidates\SettingController;
use App\Http\Controllers\Candidates\SupportController;
use App\Http\Controllers\Candidates\Support\SupportController as CandidateSupportController;
use App\Http\Controllers\Candidates\UsefulInformationController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])->name('candidate.register');
Route::middleware(['auth', 'is_candidate'])->group(function () {
    Route::get('/', [DashController::class, 'dashboard'])->name('candidate.dashboard');
    Route::get('/jobs', [DashController::class, 'jobs'])->name('candidate.jobs');
    Route::get('/profile', [DashController::class, 'profile'])->name('candidate.profile');
    Route::get('/show/{id}', [DashController::class, 'show'])->name('candidate.profile.show');
    Route::get('/safty-tips', [DashController::class, 'safty-tips'])->name('candidate.safty-tips');
    Route::get('settings', [DashController::class, 'settings'])->name('candidate.settings');
    Route::get('job-preferences', [DashController::class, 'job_preferences'])->name('candidate.job-preferences');
    Route::post('/follow-company/', [DashController::class, "follow_company"])->name("candidate.follow_company");
    Route::get('/notifications', [DashController::class, "getNotifications"])->name('candidate.get-notifications');

    // Save Profile
    Route::post('/profile', [DashController::class, 'saveProfile'])->name('candidate.save-profile');
    Route::post('/job-preferences', [DashController::class, 'saveJobPreferences'])->name('candidate.save-job-preferences');
    Route::post('/settings', [DashController::class, 'saveSettings'])->name('candidate.save-settings');

    Route::put('/update-profile/{id}', [DashController::class, 'update'])->name('candidate.updateProfile');

    Route::group(['prefix' => 'company/', 'as' => 'candidate.'], function () {
        Route::get('lists', [DashController::class, 'company_lists'])->name('company_lists');
    });

    Route::group(['prefix' => 'saved-jobs/', 'as' => 'candidate.savedjob.'], function () {
        Route::get('lists', [JobController::class, 'saveJobLists'])->name('saveJobLists');
        Route::post('store', [JobController::class, 'saveJob'])->name('saveJob');
        Route::delete('delete/{id}', [JobController::class, 'delete'])->name('delete');
    });

    Route::group(['prefix' => 'recommended-job/', 'as' => 'candidate.'], function () {
        Route::get('', [JobController::class, 'recommended_job'])->name('recommended_job');
    });

    // Workout on New profile design
    Route::group(['prefix' => 'profile/', 'as' => 'candidate.profile.'], function () {
        Route::get('index', [ProfileController::class, 'profile'])->name('index');
        Route::get('get-personal-information', [ProfileController::class, 'get_personal_information'])->name('get_personal_information');
        Route::post('post-personal-information', [ProfileController::class, 'post_personal_information'])->name('post_personal_information');
        Route::get('get-contact-information', [ProfileController::class, 'get_contact_information'])->name('get_contact_information');
        Route::post('post-contact-information', [ProfileController::class, 'post_contact_information'])->name('post_contact_information');
        Route::get('get-qualification', [ProfileController::class, 'get_qualification'])->name('get_qualification');
        Route::post('post-qualification', [ProfileController::class, 'post_qualification'])->name('post_qualification');
        Route::get('get-experience', [ProfileController::class, 'get_experience'])->name('get_experience');
        Route::post('post-experience', [ProfileController::class, 'post_experience'])->name('post_experience');
        Route::get('get-preferred-jobs', [ProfileController::class, 'get_preferred_jobs'])->name('get_preferred_jobs');
        Route::post('post-preferred-jobs', [ProfileController::class, 'post_preferred_jobs'])->name('post_preferred_jobs');
        Route::get('get-preview', [ProfileController::class, 'get_preview'])->name('get_preview');
        Route::get('get-save', [ProfileController::class, 'get_save'])->name('get_save');
        Route::get('get-cv', [ProfileController::class, 'get_cv'])->name('get_cv');
        Route::get('download-cv', [ProfileController::class, 'downloadGeneratedCV'])->name('downloadGeneratedCV');
        Route::post('upload-cv', [ProfileController::class, 'uploadCv'])->name('uploadCv');
        Route::get('download-uploaded-cv', [ProfileController::class, 'downloadUploadedCv'])->name('downloadUploadedCv');
        Route::get('remove-uploaded-cv', [ProfileController::class, 'removeCv'])->name('removeCv');
        Route::post('update-candidate-avatar', [ProfileController::class, 'updateCandidateProfile'])->name('updateCandidateProfile');
    });

    Route::group(['prefix' => 'account-setting/', 'as' => 'candidate.account_setting.'], function () {
        Route::get('index', [SettingController::class, 'get_setting'])->name('index');
        Route::post('update-setting', [SettingController::class, 'update_setting'])->name('update_setting');
        Route::get('change-password', [SettingController::class, 'get_change_password'])->name('get_change_password');
        Route::post('post-change-password', [SettingController::class, 'post_change_password'])->name('post_change_password');
        Route::get('get-account-setting', [SettingController::class, 'get_account_setting'])->name('get_account_setting');
        Route::post('post-account-setting', [SettingController::class, 'post_account_setting'])->name('post_account_setting');
    });

    Route::group(['prefix' => 'useful-info/', 'as' => 'candidate.usefulinfo.'], function () {
        Route::get('index', [UsefulInformationController::class, 'index'])->name('index');
        Route::get('detail/{slug}', [UsefulInformationController::class, 'detail'])->name('detail');
    });

    Route::group(['prefix' => 'job-setting/', 'as' => 'candidate.job_setting.'], function () {
        Route::get('index', [JobSettingController::class, "get_job_preference"])->name("index");
        Route::get('alert', [JobSettingController::class, "get_job_alert"])->name("get_job_alert");
        Route::post('post-job-preference', [JobSettingController::class, "post_job_preference"])->name("post_job_preference");
        Route::post('update-job-notification', [JobSettingController::class, 'updateJobNotification'])->name('updateJobNotification');
    });

    Route::group(['prefix' => 'support/', 'as' => 'candidate.support.'], function () {
        Route::get('index', [SupportController::class, 'get_support'])->name('index');
        Route::get('', [CandidateSupportController::class, 'index'])->name('support');
        Route::get('support-questions/{slug}', [CandidateSupportController::class, 'get_support_questions'])->name('get_supports');
        Route::get('support-answer/{slug}', [CandidateSupportController::class, 'get_question_answer'])->name('get_support_answer');
    });

    Route::group(['prefix' => 'job-search/', 'as' => 'candidate.job_search.'], function () {
        Route::get('index', [JobSearchController::class, 'index'])->name('index');
        Route::get('jobdetail/{id}', [JobSearchController::class, 'viewJobDetails'])->name('viewJobDetails');
    });

    Route::group(['prefix' => 'job-application/', 'as' => 'candidate.job_application.'], function () {
        Route::get('index/{type?}', [JobApplicationController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => 'news/', 'as' => 'candidate.news.'], function () {
        Route::get('index', [NewsController::class, 'index'])->name('index');
        Route::get('detail/{slug}', [NewsController::class, 'newsdetail'])->name('detail');
    });

    // End Working out New Profile Design
});
