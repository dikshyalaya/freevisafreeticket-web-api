<?php

namespace App\Http\Controllers\Admin;

use App\Enum\JobApplicationStatus;
use App\Http\Controllers\Controller;
use App\Models\ApplicantFilter;
use App\Models\Company;
use App\Models\Country;
use App\Models\EducationLevel;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobPreference;
use App\Models\Language;
use App\Models\Skill;
use App\Models\Training;
use App\Traits\Admin\AdminMethods;
use Illuminate\Http\Request;

class ApplicationManagementController extends Controller
{
    use AdminMethods;

    private $page = "admin.pages.newapplicant.";

    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $applicants = JobApplication::when($request->status != null, function ($q) use ($request) {
            $q->where('status', $request->status);
        })->whereHas('job', function ($query) use ($request) {
            return $query->when(!blank($request->jobTitle) and $request->jobTitle != 'All Job Titles', function ($q) use ($request) {
                $q->where('job_categories_id', $request->jobTitle);
            })->when(!blank($request->jobTitle) and $request->jobTitle == 'All Job Titles', function ($q) use ($request) {
                $categoriesId = JobCategory::pluck('id')->toArray();
                $q->whereIn('job_categories_id', $categoriesId);
            })->when(!blank($request->countries) AND $request->countries != 'All Countries', function($q) use($request){
                $q->where('country_id', $request->countries);
            })->when(!blank($request->countries) AND $request->countries == 'All Countries', function($q) use($request){
                $countriesId = Country::pluck('id')->toArray();
                $q->whereIn('country_id', $countriesId);
            })->when(!blank($request->companies) AND $request->companies != 'All Companies', function($q) use($request){
                $q->where('company_id', $request->companies);
            })->when(!blank($request->companies) AND $request->companies == 'All Companies', function($q) use($request){
                $companiesId = Company::pluck('id')->toArray();
                $q->whereIn('company_id', $companiesId);
            })->with(['employe', 'job']);
        });
        $totalApplicant = $applicants->count();
        if ($request->limit != 'All') {
            $applicants = $applicants->paginate($request->limit ?? 10);
        } else {
            $applicants = $applicants->paginate($applicants->count());
        }
        $sn = ($applicants->perPage() * ($applicants->currentPage() - 1)) + 1;
        return $this->view($this->page . 'index', [
            'application_datas' => $this->__datas()['application_datas'],
            'applicants' => $applicants,
            'job_categories' => JobCategory::whereHas('jobs')->get(),
            'countries' => Country::where('is_active', 1)->get(),
            'companies' => Company::whereHas('jobs')->get(),
            'sn' => $sn,
            'totalApplicant' => $totalApplicant,
            'pagination' => $applicants->appends([
                'limit' => $request->limit,
                'status' => $request->status,
                'q' => $request->q,
                'jobTitle' => !blank($request->jobTitle) ? $request->jobTitle : '',
                'countries' => !blank($request->countries) ? $request->countries : '',
                'companies' => !blank($request->companies) ? $request->companies : '',
            ]),
        ]);
    }

    public function advancedSearch(Request $request)
    {
        $jobPreferredCategories = JobPreference::where('job_preference_type', get_class(new JobCategory()))->pluck('job_preference_id')->toArray();
        $jobPreferredCountries = JobPreference::where('job_preference_type', get_class(new Country()))->pluck('job_preference_id')->toArray();
        return $this->view($this->page . 'advancedSearch', [
            "education_levels" => EducationLevel::select("id", "title")->get(),
            "skills" => Skill::select("id", "title")->get(),
            "trainings" => Training::select("id", "title")->get(),
            "languages" => Language::select("id", "lang")->get(),
            "preferredCategories" => JobCategory::whereIn("id", $jobPreferredCategories)->select("id", "functional_area")->get(),
            "preferredCountries" => Country::whereIn("id", $jobPreferredCountries)->select("id", "name")->get(),
            "applicantFilters" => ApplicantFilter::get(),
            "job_categories" => JobCategory::has('jobs')->get(),
        ]);
    }

    public function viewApplicant(Request $request, $id)
    {
        $applicant = JobApplication::where('id', $id)->with(['job', 'employe'])->firstOrFail();
        return $this->view($this->page.'viewapplicant',[
            'applicant' => $applicant,
        ]);
    }

    private function __datas()
    {
        $jobapplication = JobApplication::query();
        return [
            'application_datas' => [
                [
                    'title' => 'All Applications',
                    'link' => route('admin.applicant.indexpage'),
                    'totalcount' => $jobapplication->count(),
                    'image' => 'mail.svg',
                    'bg-color' => 'bg-blue',
                ],
                [
                    'title' => 'Unscreened Applications',
                    'link' => route('admin.applicant.indexpage', ['status' => JobApplicationStatus::PENDING]),
                    'totalcount' => $jobapplication->where('status', JobApplicationStatus::PENDING)->count(),
                    'image' => 'megaphone.svg',
                    'bg-color' => 'bg-gray',
                ],
                [
                    'title' => 'Shortlisted Applications',
                    'link' => route('admin.applicant.indexpage', ['status' => JobApplicationStatus::SHORT_LISTED]),
                    'totalcount' => $jobapplication->where('status', JobApplicationStatus::SHORT_LISTED)->count(),
                    'image' => 'blogging.svg',
                    'bg-color' => 'bg-pink',
                ],
                [
                    'title' => 'Interviewed Applications',
                    'link' => route('admin.applicant.indexpage', ['status' => JobApplicationStatus::SELECTED_FOR_INTERVIEW]),
                    'totalcount' => $jobapplication->where('status', JobApplicationStatus::SELECTED_FOR_INTERVIEW)->count(),
                    'image' => 'picture.svg',
                    'bg-color' => 'bg-orange',
                ],
                [
                    'title' => 'Selected Applications',
                    'link' => route('admin.applicant.indexpage', ['status' => JobApplicationStatus::ACCEPTED]),
                    'totalcount' => $jobapplication->where('status', JobApplicationStatus::ACCEPTED)->count(),
                    'image' => 'picture.svg',
                    'bg-color' => 'bg-green',
                ],
                [
                    'title' => 'Rejected Applications',
                    'link' => route('admin.applicant.indexpage', ['status' => JobApplicationStatus::REJECTED]),
                    'totalcount' => $jobapplication->where('status', JobApplicationStatus::REJECTED)->count(),
                    'image' => 'box-closed.svg',
                    'bg-color' => 'bg-red',
                ],
            ],
        ];
    }
}
