<?php

namespace App\Http\Controllers\Company;

use App\Enum\ApplicantStatus;
use App\Enum\JobApplicationStatus;
use App\Http\Controllers\Controller;
use App\Models\ApplicantFilter;
use App\Models\Company;
use App\Models\Country;
use App\Models\EducationLevel;
use App\Models\Employe;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobPreference;
use App\Models\Language;
use App\Models\Skill;
use App\Models\Training;
use App\Traits\Api\ApiMethods;
use App\Traits\Site\CompanyMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PDF;

class NewApplicantController extends Controller
{
    use CompanyMethods, ApiMethods;

    private $page = "company.newapplicant.";

    public function __construct()
    {
        $GLOBALS['page-name'] = "Applicant";
    }

    public function index(Request $request)
    {
        // $applicants = JobApplication::when($request->status != null, function ($q) use ($request) {
        //     $q->where('status', $request->status);
        // })->whereHas('job', function ($query) {
        //     return $query->whereHas('company', function ($query2) {
        //         return $query2->where('user_id', Auth::user()->id)->with(['employe', 'job']); // don't remove
        //     });
        // });
        $applicants = JobApplication::when($request->status != null, function ($q) use ($request) {
            $q->where('status', $request->status);
        })->whereHas('job', function ($query) use ($request) {
            return $query->whereHas('company', function ($query2) use ($query, $request) {
                $query->when(!blank($request->jobTitle) and $request->jobTitle != 'All Job Titles', function ($q) use ($request) {
                    $q->where('job_categories_id', $request->jobTitle);
                })->when(!blank($request->jobTitle) and $request->jobTitle == 'All Job Titles', function ($q) use ($request) {
                    $categoriesId = JobCategory::pluck('id')->toArray();
                    $q->whereIn('job_categories_id', $categoriesId);
                })->when(!blank($request->countries) and $request->countries != 'All Countries', function ($q) use ($request) {
                    $q->where('country_id', $request->countries);
                })->when(!blank($request->countries) and $request->countries == 'All Countries', function ($q) use ($request) {
                    $countriesId = Country::pluck('id')->toArray();
                    $q->whereIn('country_id', $countriesId);
                });
                return $query2->where('user_id', Auth::user()->id)->with(['employe', 'job']);
            });
        });
        $totalApplicant = $applicants->count();
        if ($request->limit != 'All') {
            $applicants = $applicants->paginate($request->limit ?? 10);
        } else {
            $applicants = $applicants->paginate($applicants->count());
        }
        $sn = ($applicants->perPage() * ($applicants->currentPage() - 1)) + 1;
        return $this->company_view($this->page . 'index', [
            "application_datas" => $this->__datas()['application_datas'],
            "applicants" => $applicants,
            "companies" => Company::whereHas('jobs')->get(),
            "sn" => $sn,
            "totalApplicant" => $totalApplicant,
            "pagination" => $applicants->appends([
                'limit' => $request->limit,
                'status' => $request->status,
                'q' => $request->q,
                'jobTitle' => !blank($request->jobTitle) ? $request->jobTitle : '',
                'countries' => !blank($request->countries) ? $request->countries : '',
            ]),
        ]);

    }

    public function getApplicants(Request $request)
    {
        // dd($request->all());
        $input = json_decode($request->filter, true);
        $formData = !blank($input['formData']) ? json_decode($input['formData']) : '';
        // dd($input);
        $query = JobApplication::query();
        
        if (!blank($formData)) {
            $query = JobApplication::when(!blank($formData->application_status), function($q) use($formData){
                $q->where('status', $formData->application_status);
            });
            $query->whereHas('job', function ($query) use ($formData) {
                return $query->when(!blank($formData->job_title), function ($q) use ($formData) {
                    $q->orWhere('job_categories_id', $formData->job_title);
                })->when(!blank($formData->preferred_jobs), function ($q) use ($formData) {
                    $q->orWhereIn('job_categories_id', $formData->preferred_jobs);
                })->when(!blank($formData->min_age) and blank($formData->max_age), function ($q) use ($formData) {
                    $q->orWhere('min_age', $formData->min_age);
                })->when(!blank($formData->max_age) and blank($formData->min_age), function ($q) use ($formData) {
                    $q->orWhere('max_age', $formData->max_age);
                })->when(!blank($formData->min_age) and !blank($formData->max_age), function ($q) use ($formData) {
                    $q->orWhere('min_age', $formData->min_age)->orWhere('max_age', $formData->max_age);
                })->when(!blank($formData->preferred_countries), function ($q) use ($formData) {
                    $q->orWhereIn('country_id', $formData->preferred_countries);
                });
                return $query->whereHas('company', function ($query2) {
                    $query2->where('user_id', Auth()->user()->id);
                });
            });
        } else {
            $query->whereHas('job', function ($query) use ($input) {
                return $query->whereHas('company', function ($query) {
                    return $query->where('user_id', AUth()->user()->id);
                });
            });
        }

        $query->with([
            'employe', 'employe.country:id,name', 'employe.user',
            'job', 'job.job_category', 'employe.experience.country:id,name', 'employe.experience.job_category:id,functional_area',
            'employe.education_level:id,title', 'employe.employeeTrainings.training:id,title', 'employe.employeeLanguage.language:id,lang',
            'employe.employeeSkills.skill:id,title', 'employe.countryPreference:id,name', 'employe.jobCategoryPreference:id,functional_area',
        ]);

        // filter
        if (!blank($input)) {

            // text search
            if (isset($input['query']) and !blank($input['query'])) {
                $input_query = $input['query'];
                $query->whereHas('employe', function ($query) use ($input_query) {
                    $query->where('first_name', 'like', '%' . $input_query . '%');
                    $query->orWhere('middle_name', 'like', '%' . $input_query . '%');
                    $query->orWhere('last_name', 'like', '%' . $input_query . '%');
                });
            }

            // Job Application Filter
            if (isset($input['application_status']) and !blank($input['application_status'])) {
                $input_query = $input['application_status'];
                $query->where('status', $input_query);
            }

            // Job Category Filter
            if (isset($input['category']) and !blank($input['category'])) {
                $input_query = $input['category'];
                $query->whereHas('job', function ($query) use ($input_query) {
                    $query->where('job_categories_id', $input_query);
                });
            }

            // Job Country Filter
            if (isset($input['country']) and !blank($input['country'])) {
                $input_query = $input['country'];
                $query->whereHas('job', function ($query) use ($input_query) {
                    $query->where('country_id', $input_query);
                });
            }

            if (!blank($formData)) {
                $query->when(!blank($formData->from_date) and blank($formData->to_date), function ($q) use ($formData) {
                    $q->where(DB::raw('CAST(created_at as date)'), $formData->from_date);
                })->when(!blank($formData->to_date) and blank($formData->from_date), function ($q) use ($formData) {
                    $q->where(DB::raw('CAST(created_at as date)'), $formData->to_date);
                })->when(!blank($formData->from_date) and !blank($formData->to_date), function ($q) use ($formData) {
                    $q->orWhereBetween(DB::raw('CAST(created_at as date)'), [$formData->from_date, $formData->to_date]);
                })->whereHas('employe', function ($query2) use ($formData) {
                    return $query2->when(!blank($formData->gender), function ($q) use ($formData) {
                        $q->where('gender', $formData->gender);
                    })
                    // ->when(!blank($formData->profile_score), function($q) use ($formData){
                    //     $q->having('profile_score', $formData->profile_score);
                    // })
                    ->whereHas('employeeSkills', function($query3) use($formData){
                        $query3->whereHas('skill', function($query4) use($formData){
                            $query4->orWhereIn('id', $formData->skills);
                        });
                    })->whereHas('employeeTrainings', function($query6) use($formData){
                        $query6->whereHas('training', function($query7) use($formData){
                            $query7->orWhereIn('id', $formData->trainings);
                        });
                    })->whereHas('employeeLanguage', function($query8) use($formData){
                        $query8->whereHas('language', function($query9) use($formData){
                            $query9->orWhereIn('id', $formData->languages);
                        });
                    });
                });
            }

        }

        if ($request->limit != 'All') {
            $applicants = $query->paginate($request->limit ?? 50);
        } else {
            $applicants = $query->paginate($query->count());
        }

        // $applicants = $query->paginate(2);

        return $this->sendResponse(compact('applicants'), 'success', '', true);
    }

    public function getDataSets()
    {
        // application status
        $status_count = [];
        if ($this->company()) {
            $status_count['total'] = $this->company()->job_applications->count();
            $status_count['pending'] = $this->company()->job_applications->where('status', JobApplicationStatus::PENDING)->count();
            $status_count['shortlisted'] = $this->company()->job_applications->where('status', JobApplicationStatus::SHORT_LISTED)->count();
            $status_count['interviewed'] = $this->company()->job_applications->where('status', JobApplicationStatus::INTERVIEWED)->count();
            $status_count['accepted'] = $this->company()->job_applications->where('status', JobApplicationStatus::ACCEPTED)->count();
            $status_count['rejected'] = $this->company()->job_applications->where('status', JobApplicationStatus::REJECTED)->count();
        }

        // job categories
        $job_categories = JobCategory::whereHas('jobs')->get();
        $countries = Country::where('is_active', 1)->get();

        $jobPreferredCategories = JobPreference::where('job_preference_type', get_class(new JobCategory()))->pluck('job_preference_id')->toArray();
        $jobPreferredCountries = JobPreference::where('job_preference_type', get_class(new Country()))->pluck('job_preference_id')->toArray();

        $education_levels = EducationLevel::select("id", "title")->get();
        $skills = Skill::select("id", "title")->get();
        $trainings = Training::select("id", "title")->get();
        $languages = Language::select("id", "lang")->get();
        $preferredCategories = JobCategory::whereIn("id", $jobPreferredCategories)->select("id", "functional_area")->get();
        $preferredCountries = Country::whereIn("id", $jobPreferredCountries)->select("id", "name")->get();
        $applicationStatus = [
            ApplicantStatus::PENDING,
            ApplicantStatus::SHORTLISTED,
            ApplicantStatus::SELECTEDFORINTERVIEW,
            ApplicantStatus::INTERVIEWED,
            ApplicantStatus::ACCEPTED,
            ApplicantStatus::REJECTED,
            ApplicantStatus::REDLISTED,
        ];
        $applicant_filters = ApplicantFilter::get();

        return $this->sendResponse(
            compact(
                'status_count',
                'job_categories',
                'countries',
                'education_levels',
                'skills',
                'trainings',
                'languages',
                'preferredCategories',
                'preferredCountries',
                'applicationStatus',
                'applicant_filters'
            ), 'success', '', true);
    }

    public function advancedSearch(Request $request)
    {
        $jobPreferredCategories = JobPreference::where('job_preference_type', get_class(new JobCategory()))->pluck('job_preference_id')->toArray();
        $jobPreferredCountries = JobPreference::where('job_preference_type', get_class(new Country()))->pluck('job_preference_id')->toArray();
        return $this->company_view($this->page . "advancedSearch", [
            "education_levels" => EducationLevel::select("id", "title")->get(),
            "skills" => Skill::select("id", "title")->get(),
            "trainings" => Training::select("id", "title")->get(),
            "languages" => Language::select("id", "lang")->get(),
            "preferredCategories" => JobCategory::whereIn("id", $jobPreferredCategories)->select("id", "functional_area")->get(),
            "preferredCountries" => Country::whereIn("id", $jobPreferredCountries)->select("id", "name")->get(),
            "applicantFilters" => ApplicantFilter::get(),
        ]);
    }

    public function bulkUpdateApplicationStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "ids" => ["required"],
            "applicantStatus" => ["required"],
        ]);
        if ($validator->fails()) {
            return response()->json(['db_error' => $validator->errors(), 'success' => false]);
        }
        try {
            DB::beginTransaction();
            $ids = $request->ids;
            $explodedIds = explode(",", $ids);
            foreach ($explodedIds as $explodedId) {
                $application = JobApplication::where('id', $explodedId);
                if ($application->exists()) {
                    $application = $application->first();
                    $application->update(['status' => $request->applicantStatus, 'interview_date' => null, 'interview_status' => 'notstarted', 'interview_time' => null]);
                    $statuses[] = [
                        $application->id => ucfirst($application->status),
                    ];
                }
            }
            DB::commit();
            return response()->json(['msg' => "Application Status Updated", 'success' => true, 'statuses' => json_encode($statuses)]);
        } catch (\Exception$e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage(), 'success' => false]);
        }
    }

    public function bulkCvDownload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "ids" => ["required"],
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'success' => false]);
        }
        try {
            $ids = $request->ids;
            $exploded_ids = explode(",", $ids);
            foreach ($exploded_ids as $explodedId) {
                $application = JobApplication::where("id", $explodedId);
                if ($application->exists()) {
                    $application = $application->first();
                    $employe = Employe::where('id', $application->employ_id);
                    if ($employe->exists()) {
                        $employeId = $employe->value('id');
                        $employeIds[] = $employeId;
                    }
                }
            }
            $employeIds = array_unique($employeIds);
            $employes = Employe::whereIn("id", (array) $employeIds)->with([
                'user:id,email',
                'country:id,name',
                'state:id,name',
                'city:id,name',
                'education_level:id,title',
                'employeeSkills.skill:id,title',
                'employeeLanguage.language:id,lang',
                'experience.country:id,name',
                'experience.job_category:id,functional_area',
                'experience.industry:id,title',
            ])->get();
            // PDF Generation
            $pdf = PDF::loadView('themes.fvft.candidates.bulkcv', compact('employes'));
            if (!file_exists('uploads/cv/')) {
                mkdir('uploads/cv/', 0777, true);
            }
            $path = public_path('uploads/cv/');
            $fileName = 'Applicants.pdf';
            $pdf->save($path . $fileName);
            $pdf = public_path('uploads/cv/' . $fileName);
            return response()->download($pdf);
        } catch (\Exception$e) {
            return response()->json(['error' => $e->getMessage(), 'success' => false]);
        }
    }

    public function bulkApplicationDelete(Request $request)
    {
        // dd($request->ids);
        try {
            DB::beginTransaction();
            $ids = $request->ids;
            $explodedIds = explode(",", $ids);
            JobApplication::destroy($explodedIds);
            DB::commit();
            return response()->json(['success' => true, 'msg' => 'Bulk Application Deleted']);
        } catch (\Exception$e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function bulkScheduleInterview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'interview_date' => ['required'],
            'interview_time' => ['required'],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false]);
        }
        try {
            DB::beginTransaction();
            $ids = $request->ids;
            $explodedIds = explode(",", $ids);
            JobApplication::whereIn('id', $explodedIds)->update([
                'interview_date' => $request->interview_date,
                'interview_time' => $request->interview_time,
                'interview_status' => 'started',
                'status' => JobApplicationStatus::SELECTED_FOR_INTERVIEW,
            ]);
            foreach ($explodedIds as $eIds) {
                $statuses[] = [
                    $eIds => JobApplicationStatus::SELECTED_FOR_INTERVIEW,
                ];
            }

            DB::commit();
            return response()->json(['success' => true, 'msg' => 'Interview Status updated for selected applicants', 'statuses' => json_encode($statuses)]);
        } catch (\Exception$e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    private function __route($type)
    {
        return route('company.jobs', ['type' => $type]);
    }

    private function __datas()
    {
        return [
            'application_datas' => [
                [
                    'title' => 'All Applications',
                    'link' => route('company.applicant.indexpage'),
                    'totalcount' => ($this->company()) ? $this->company()->job_applications->count() : '',
                    'image' => 'mail.svg',
                    'bg-color' => 'bg-blue',
                ],
                [
                    'title' => 'Unscreened Applications',
                    'link' => route('company.applicant.indexpage', ['status' => JobApplicationStatus::PENDING]),
                    'totalcount' => ($this->company()) ? $this->company()->job_applications->where('status', JobApplicationStatus::PENDING)->count() : '',
                    'image' => 'megaphone.svg',
                    'bg-color' => 'bg-gray',
                ],
                [
                    'title' => 'Shortlisted Applications',
                    'link' => route('company.applicant.indexpage', ['status' => JobApplicationStatus::SHORT_LISTED]),
                    'totalcount' => ($this->company()) ? $this->company()->job_applications->where('status', JobApplicationStatus::SHORT_LISTED)->count() : '',
                    'image' => 'blogging.svg',
                    'bg-color' => 'bg-pink',
                ],
                [
                    'title' => 'Interviewed Applications',
                    'link' => route('company.applicant.indexpage', ['status' => JobApplicationStatus::SELECTED_FOR_INTERVIEW]),
                    'totalcount' => ($this->company()) ? $this->company()->job_applications->where('status', JobApplicationStatus::SELECTED_FOR_INTERVIEW)->count() : '',
                    'image' => 'picture.svg',
                    'bg-color' => 'bg-orange',
                ],
                [
                    'title' => 'Selected Applications',
                    'link' => route('company.applicant.indexpage', ['status' => JobApplicationStatus::ACCEPTED]),
                    'totalcount' => ($this->company()) ? $this->company()->job_applications->where('status', JobApplicationStatus::ACCEPTED)->count() : '',
                    'image' => 'picture.svg',
                    'bg-color' => 'bg-green',
                ],
                [
                    'title' => 'Rejected Applications',
                    'link' => route('company.applicant.indexpage', ['status' => JobApplicationStatus::REJECTED]),
                    'totalcount' => ($this->company()) ? $this->company()->job_applications->where('status', JobApplicationStatus::REJECTED)->count() : '',
                    'image' => 'box-closed.svg',
                    'bg-color' => 'bg-red',
                ],
            ],
        ];
    }
}
