<?php

namespace App\Http\Controllers\Candidates;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\Company;
use App\Models\Country;
use App\Models\Employe;
use App\Models\SavedJob;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use App\Traits\Site\ThemeMethods;
use Illuminate\Support\Facades\DB;
use App\Models\EmployJobPreference;
use App\Http\Controllers\Controller;
use App\Traits\Site\CandidateMethods;

class JobSearchController extends Controller
{
    use ThemeMethods, CandidateMethods;
    private $page = "candidates.job_search.";

    public function __construct()
    {
        $this->Countries = Country::whereHas('jobs')->select('id', 'name', 'iso2', 'iso3')->withCount('jobs')->get();
        $this->jobCategories = JobCategory::whereHas('jobs')->select('id', 'functional_area')->withCount('jobs')->take(18)->inRandomOrder()->get();
        $this->companies = Company::whereHas('jobs')->select('id', 'company_name', 'company_logo')->withCount('jobs')->get();
    }

    public function index(Request $request)
    {

        $query = Job::query();
        // $jobs = $query->where('publish_status', 1); //Todo uncomment later
        $action = $this->actions($request->type);
        $this->__query_jobs($query, $request);
        $jobs = $query->with(['company', 'country', 'job_category'])->paginate(10);
        return $this->client_view($this->page . 'index', [
            'jobs' => $jobs,
            "pagination" => $jobs->appends(array(
                'type' => $request->type,
                'country_id' => $request->country_id,
                'category_id' => $request->category_id,
                'company_id' => $request->company_id,
                'search' => $request->search,
            )),
            'action' => $action,
            'employ' => $this->employe(),
            'Countries' => $this->Countries,
            'jobCategories' => $this->jobCategories,
            'companies' => $this->companies,
        ]);
    }

    private function __query_jobs($query, $request)
    {
        $category_id = [];
        $job_title = [];
        $country_id = [];

        $query->when($request->type == 'all', function ($q) {
            $q;
        })->when($request->type == 'featured_jobs', function ($q) {
            $q->where('is_featured', 1);
        })->when($request->type == 'new_jobs', function ($q) {
            $q->where('publish_status', 1)->orderBy('created_at', 'DESC');
            // $q->where('publish_status', 1)->whereDate('created_at', '>=', Carbon::now()->subDays(30)); // don't remove
        })->when($request->type == 'saved_jobs', function ($q) {
            $q->whereIn('id', function ($q1) {
                $q1->select('job_id')->from((new SavedJob)->getTable())->where('employ_id', $this->employe()->id);
            });
        })->when($request->type == 'jobs_by_country', function ($q) use ($request) {
            $q->where('country_id', $request->country_id);
        })->when($request->type == 'jobs_by_category', function ($q) use ($request) {
            $q->where('job_categories_id', $request->category_id);
        })->when($request->type == 'jobs_by_company', function ($q) use ($request) {
            $q->where('company_id', $request->company_id);
        })->when($request->type == 'prefered_jobs', function ($q) use ($category_id, $job_title, $country_id) {
            // $preference = EmployJobPreference::where('employ_id', $this->employe()->id)->get();
            // $category_id = array_merge($category_id, $preference->whereNotNull('job_category_id')->pluck('job_category_id')->toArray());
            // $job_title = array_merge($job_title, $preference->whereNotNull('job_title')->pluck('job_title')->toArray());
            // $country_id = array_merge($country_id, $preference->whereNotNull('country_id')->pluck('country_id')->toArray());
            // $q->whereIn('job_categories_id', $category_id)
            //     ->orWhereIn('country_id', $country_id)->when($job_title, function ($q3) use ($job_title) {
            //     foreach ($job_title as $title) {
            //         $q3->orWhere('title', 'LIKE', '%' . $title . '%');
            //     }
            // });
            $industry_preferences = $this->employe()->industryPreference()->pluck('job_preference_id')->toArray();
            $job_category_preferences = $this->employe()->jobCategoryPreference()->pluck('job_preference_id')->toArray();
            $country_preferences = $this->employe()->countryPreference()->pluck('job_preference_id')->toArray();
            $q->whereIn('job_categories_id', $job_category_preferences)
            ->orWhereIn('country_id', $country_preferences)
            ->when($industry_preferences, function($q3) use ($industry_preferences){
                $companies = Company::whereIn('industry_id', $industry_preferences)->pluck('id')->toArray();
                $q3->orWhereIn('company_id', $companies);
            });
        })->when($request->has('search'), function ($q) use ($request) {
            $q->where('title', 'LIKE', '%' . $request->search . '%');
        });
    }

    public function viewJobDetails(Request $request, $id)
    {
        $job = Job::find($id);
        $action = $this->actions($request->type);
        if ($job) {
            $company = Company::where('id', $job->company_id)->first();
            $company_contact_persons = DB::table('company_contact_persons')->where('company_id', $job->company_id)->first();
            $fields = [
                "job" => Job::where('id', $id)->with('company', 'country', 'job_category')->first(),
                "company_contact_persons" => $company_contact_persons,
                "company" => $company
            ];
            if (auth()->check() && auth()->user()->user_type == "candidate") {
                $employ = Employe::where('user_id', auth()->user()->id)->with('employeeSkills')->first();
                $application = DB::table('job_applications')->where('job_id', $id)->where('employ_id', $employ->id)->first();
                $fields['application'] = $application;
                $fields['employ'] = $employ;
            }
            $fields['action'] = $action;
            return $this->client_view($this->page.'jobdetail', $fields);
        } else {
            return abort(404);
        }
    }

    private function actions($type)
    {
        switch ($type) {
            case 'all':
                return 'All Jobs';
                break;
            case 'prefered_jobs':
                return 'Preferred Jobs';
                break;
            case 'featured_jobs':
                return 'Featured Jobs';
                break;
            case 'new_jobs':
                return 'New Jobs';
                break;
            case 'jobs_by_country':
                return 'Jobs By Country';
                break;
            case 'jobs_by_category':
                return 'Jobs By Category';
                break;
            case 'jobs_by_company':
                return 'Jobs By Company';
                break;
            case 'saved_jobs':
                return 'Saved Jobs';
                break;
            default:
                return 'All Jobs';
        }
    }
}
