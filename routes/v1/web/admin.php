<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Ajax\AddController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Jobs\AjaxJobController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\Jobs\JobsController;
use App\Http\Controllers\Admin\Jobs\JobsAjaxController;
use App\Http\Controllers\Admin\Location\LocationAjaxController;

use App\Http\Controllers\Admin\Companies\CompanyController;
use App\Http\Controllers\Admin\Candidates\CandidateController;
use App\Http\Controllers\Admin\Pages\PageController;
use App\Http\Controllers\Admin\Applicants\ApplicantController;
use App\Http\Controllers\Admin\ApplicationManagementController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\News\NewsController;
use App\Http\Controllers\Admin\Industry\IndustryController;
use App\Http\Controllers\Admin\JobcategoryController;
use App\Http\Controllers\Admin\Training\TrainingController;
use App\Http\Controllers\Admin\SantiController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\Site\GeneralSettingController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\SupportCategoryController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\UsefulInformationController;

Route::get('login', function () {
    return view('admin.auth.login');
})->name('admin.login');

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/jobs-list', [JobsController::class, 'index'])->name('admin.jobs-list');
    Route::get('/jobs-save', [JobsController::class, 'edit']);
    Route::post('/jobs-save', [JobsController::class, 'save']);
    Route::get('/jobs-delete/{id}', [JobsController::class, 'delete'])->name('admin.jobs.delete');
    Route::get('/jobs-new', [JobsController::class, 'new'])->name('admin.addNewJob');
    Route::get('/jobs-edit/{id}', [JobsController::class, 'edit'])->name('admin.editJob');
    Route::post('/save-job', [JobsController::class, 'saveNewJob'])->name('admin.saveNewJob');
    Route::put('/jobs-update/{id}', [JobsController::class, 'updateJob'])->name('admin.job.update');
    Route::get('/jobs-detail/{id}', [JobsController::class, 'viewJob'])->name('admin.job.view');
    Route::post('/jobs/update-status', [JobsController::class, 'updateJobStatus'])->name('admin.job.updateJobStatus');
    // Companies Crude
    Route::prefix('companies')->group(function () {
        Route::get('/', [CompanyController::class, 'list'])->name('admin.companies.list');
        Route::get('new', [CompanyController::class, 'new'])->name('admin.companies.new');
        Route::get('/create', [CompanyController::class, 'create'])->name('admin.companies.create');
        Route::post('/store', [CompanyController::class, 'saveCompany'])->name('admin.companies.saveCompany');
        Route::get('edit/{id}', [CompanyController::class, 'edit'])->name('admin.companies.edit');
        Route::get('delete/{id}', [CompanyController::class, 'delete'])->name('admin.companies.delete');
        Route::post('save', [CompanyController::class, 'save']);
        Route::get('show/{id}', [CompanyController::class, 'show'])->name('admin.companies.show');
        Route::get('edit-company/{id}', [CompanyController::class, 'editCompany'])->name('admin.companies.editCompany');
        Route::put('update-company/{id}', [CompanyController::class, 'updateCompany'])->name('admin.companies.udpateCompany');
    });

    // Candidate Crude
    Route::prefix('candidates')->group(function () {
        Route::get('/', [CandidateController::class, 'list'])->name('admin.candidates.list');
        Route::get('new', [CandidateController::class, 'new'])->name('admin.candidates.new');
        Route::get('create', [CandidateController::class, 'create'])->name('admin.candidates.create');
        Route::get('edit/{id}', [CandidateController::class, 'edit'])->name('admin.candidates.edit');
        Route::get('edit-candidate/{id}', [CandidateController::class, 'editCandidate'])->name('admin.candidates.editCandidate');
        Route::get('delete/{id}', [CandidateController::class, 'delete'])->name('admin.candidates.delete');
        Route::post('save', [CandidateController::class, 'save']);
        Route::post('store', [CandidateController::class, 'store'])->name('admin.candidates.store');
        Route::put('update-candidate/{id}', [CandidateController::class, 'update'])->name('admin.candidates.update');
        Route::get("candidate-details/{id}", [CandidateController::class, "show"])->name("admin.candidates.show");
    });
    // Applicants Crude
    Route::prefix('applicants')->group(function () {
        Route::get('/', [ApplicantController::class, 'list'])->name('admin.applicants.list');
        Route::get('new', [ApplicantController::class, 'new'])->name('admin.applicants.new');
        Route::get('edit/{id}', [ApplicantController::class, 'edit'])->name('admin.applicants.edit');
        Route::get('delete/{id}', [ApplicantController::class, 'delete'])->name('admin.applicants.delete');
        Route::post('save', [ApplicantController::class, 'save']);

        Route::get('index', [ApplicationManagementController::class, 'index'])->name('admin.applicant.indexpage');
        Route::get('advanced-search', [ApplicationManagementController::class, 'advancedSearch'])->name('admin.applicant.advancedSearch');
        Route::get('view-applicant/{id}', [ApplicationManagementController::class, 'viewApplicant'])->name('admin.applicant.viewApplicant');
    });
    //Pages Crude
    Route::prefix('pages')->group(function () {
        Route::get('/', [PageController::class, 'list'])->name('admin.pages.list');
        Route::get('new', [PageController::class, 'new'])->name('admin.pages.new');
        Route::get('edit/{id}', [PageController::class, 'edit'])->name('admin.pages.edit');
        Route::get('delete/{id}', [PageController::class, 'delete'])->name('admin.pages.delete');
        Route::post('save', [PageController::class, 'save']);
    });

    //News Crude
    Route::prefix('news')->group(function () {
        Route::get('/', [NewsController::class, 'list'])->name('admin.news.list');
        Route::get('new', [NewsController::class, 'new'])->name('admin.news.new');
        Route::get('edit/{id}', [NewsController::class, 'edit'])->name('admin.news.edit');
        Route::get('delete/{id}', [NewsController::class, 'delete'])->name('admin.news.delete');
        Route::post('save', [NewsController::class, 'save']);
    });

    // Useful Information
    Route::prefix('useful-info/')->group(function () {
        Route::get('', [UsefulInformationController::class, 'index'])->name('admin.usefulinfo.index');
        Route::get('create', [UsefulInformationController::class, 'create'])->name('admin.usefulinfo.create');
        Route::get('edit/{id}', [UsefulInformationController::class, 'edit'])->name('admin.usefulinfo.edit');
        Route::delete('delete/{id}', [UsefulInformationController::class, 'delete'])->name('admin.usefulinfo.delete');
        Route::post('save', [UsefulInformationController::class, 'save'])->name('admin.usefulinfo.save');
    });

    // Industry Crud
    
    Route::group(['prefix' => 'industry/', 'as' => 'admin.industry.'], function(){
        Route::get('', [IndustryController::class, "index"])->name("index");
        Route::get('create', [IndustryController::class, "create"])->name("create");
        Route::post('store', [IndustryController::class, "store"])->name("store");
        Route::get("edit/{id}", [IndustryController::class, "edit"])->name("edit");
        Route::match(['put', 'patch'], 'update/{id}', [IndustryController::class, "update"])->name("update");
        Route::delete('delete/{id}', [IndustryController::class, "delete"])->name("delete");
        Route::post('update-status', [IndustryController::class, "updateStatus"])->name("updateStatus");
    });

    // Job Category Crud
    
    Route::group(['prefix' => 'job_category/', 'as' => 'admin.job_category.'], function(){
        Route::get('', [JobcategoryController::class, "index"])->name("index");
        Route::get('create', [JobcategoryController::class, "create"])->name("create");
        Route::post('store', [JobcategoryController::class, "store"])->name("store");
        Route::get("edit/{id}", [JobcategoryController::class, "edit"])->name("edit");
        Route::match(['put', 'patch'], 'update/{id}', [JobcategoryController::class, "update"])->name("update");
        // Route::delete('delete/{id}', [JobcategoryController::class, "delete"])->name("delete");
    });

    // Country Crud
    Route::group(['prefix' => 'country/', 'as' => 'admin.country.'], function(){
        Route::get('', [CountryController::class, 'index'])->name('index');
        Route::get('create', [CountryController::class, 'create'])->name('create');
        Route::get('edit/{id}', [CountryController::class, 'edit'])->name('edit');
        Route::post('store', [CountryController::class, 'store'])->name('store');
        Route::delete('delete/{id}', [CountryController::class, 'delete'])->name('delete');
        Route::post('update-status', [CountryController::class, 'updateStatus'])->name('updateStatus');
    });

    // State Crud
    Route::group(['prefix' => 'state/', 'as' => 'admin.state.'], function(){
        Route::get('', [StateController::class, 'index'])->name('index');
        Route::get('create', [StateController::class, 'create'])->name('create');
        Route::get('edit/{id}', [StateController::class, 'edit'])->name('edit');
        Route::post('store', [StateController::class, 'store'])->name('store');
        Route::delete('delete/{id}', [StateController::class, 'delete'])->name('delete');
    });

    // City Crud
    Route::group(['prefix' => 'city/', 'as' => 'admin.city.'], function(){
        Route::get('', [CityController::class, 'index'])->name('index');
        Route::get('create', [CityController::class, 'create'])->name('create');
        Route::get('edit/{id}', [CityController::class, 'edit'])->name('edit');
        Route::post('store', [CityController::class, 'store'])->name('store');
        Route::delete('delete/{id}', [CityController::class, 'delete'])->name('delete');
    });

    // District Crud
    Route::group(['prefix' => 'district/', 'as' => 'admin.district.'], function(){
        Route::get('', [DistrictController::class, 'index'])->name('index');
        Route::get('create', [DistrictController::class, 'create'])->name('create');
        Route::get('edit/{id}', [DistrictController::class, 'edit'])->name('edit');
        Route::post('store', [DistrictController::class, 'store'])->name('store');
        Route::delete('delete/{id}', [DistrictController::class, 'delete'])->name('delete');
    });

    // SupportCategory Crud
    
    Route::group(['prefix' => 'support-category/', 'as' => 'admin.support_category.'], function(){
        Route::get('', [SupportCategoryController::class, "index"])->name("index");
        Route::get('create', [SupportCategoryController::class, "create"])->name("create");
        Route::post('store', [SupportCategoryController::class, "store"])->name("store");
        Route::get("edit/{id}", [SupportCategoryController::class, "edit"])->name("edit");
        Route::match(['put', 'patch'], 'update/{id}', [SupportCategoryController::class, "update"])->name("update");
        Route::delete('delete/{id}', [SupportCategoryController::class, "delete"])->name("delete");
    });

    // Support Crud
    
    Route::group(['prefix' => 'support/', 'as' => 'admin.support.'], function(){
        Route::get('', [SupportController::class, "index"])->name("index");
        Route::get('create', [SupportController::class, "create"])->name("create");
        Route::post('store', [SupportController::class, "store"])->name("store");
        Route::get("edit/{id}", [SupportController::class, "edit"])->name("edit");
        Route::match(['put', 'patch'], 'update/{id}', [SupportController::class, "update"])->name("update");
        Route::delete('delete/{id}', [SupportController::class, "delete"])->name("delete");
    });


    Route::group(['prefix' => 'about-fvft/', 'as' => 'admin.about.'], function(){
        Route::get('', [AboutController::class, "index"])->name("index");
        Route::get('create', [AboutController::class, "create"])->name("create");
        Route::post('store', [AboutController::class, "store"])->name("store");
        Route::get("edit/{id}", [AboutController::class, "edit"])->name("edit");
        Route::match(['put', 'patch'], 'update/{id}', [AboutController::class, "update"])->name("update");
        Route::delete('delete/{id}', [AboutController::class, "delete"])->name("delete");
        Route::post('update-status', [AboutController::class, "updateStatus"])->name("updateStatus");
    });

    Route::group(['prefix' => 'about-santi/', 'as' => 'admin.santi.'], function(){
        Route::get('', [SantiController::class, "index"])->name("index");
        Route::get('create', [SantiController::class, "create"])->name("create");
        Route::post('store', [SantiController::class, "store"])->name("store");
        Route::get("edit/{id}", [SantiController::class, "edit"])->name("edit");
        Route::match(['put', 'patch'], 'update/{id}', [SantiController::class, "update"])->name("update");
        Route::delete('delete/{id}', [SantiController::class, "delete"])->name("delete");
        Route::post('update-status', [SantiController::class, "updateStatus"])->name("updateStatus");
    });

    Route::group(['prefix' => 'training/', 'as' => 'admin.training.'], function(){
        Route::get('', [TrainingController::class, "index"])->name("index");
        Route::get("create", [TrainingController::class, "create"])->name("create");
        Route::post("store", [TrainingController::class, "store"])->name("store");
        Route::get("edit/{id}", [TrainingController::class, "edit"])->name("edit");
        Route::match(['put', 'patch'], "update/{id}", [TrainingController::class, "update"])->name("update");
        Route::post('update-status', [TrainingController::class, "updateStatus"])->name("updateStatus");
        Route::delete('delete/{id}', [TrainingController::class, "delete"])->name("delete");
        // Route::post('ajax-store-training', [TrainingController::class, "ajaxStoreTraining"])->name("ajaxAddTraining");
    });
    // Route::group(['prefix' => 'skill/', 'as' => 'admin.skill.'], function(){
    //     Route::post('ajax-store-skill', [AddController::class, "ajaxStoreSKill"])->name("ajaxAddSkill");
    // });

    Route::group(['prefix' => 'user/', 'as' => 'admin.user.'], function(){
        Route::get('', [AdminController::class, 'users'])->name('lists');
        Route::get('profile', [AdminController::class, "profile"])->name("profile");
        Route::put('update-profile', [AdminController::class, "updateProfile"])->name("updateProfile");
        Route::delete('delete-user/{id}', [AdminController::class, "delete"])->name("delete");
    });

    Route::group(['prefix' => 'general-setting/', 'as' => 'admin.general_setting.'], function(){
        Route::get('', [GeneralSettingController::class, 'index'])->name('index');
        Route::post('store', [GeneralSettingController::class, 'store'])->name('store');
    });

    Route::group(['prefix' => 'setting/', 'as' => 'admin.setting.'], function(){
        Route::get('social-setting', [SettingController::class, 'index'])->name('index');
        Route::post('save-social-setting', [SettingController::class, 'store'])->name('store');
        Route::get('contact-setting', [SettingController::class, 'getContactSetting'])->name('getContactSetting');
        Route::post('save-contact-setting', [SettingController::class, 'saveContactSetting'])->name('saveContactSetting');
    });

    Route::post('logout', [AuthController::class, 'logout']);
    // Ajax Requests

    Route::get('store-district',[DashboardController::class, "storeDistrict"]);

});
