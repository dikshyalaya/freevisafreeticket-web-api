<?php

namespace App\Http\Controllers\API\Candidates\Jobs;

use App\Enum\JobApplicationInterviewStatus;
use App\Enum\JobApplicationStatus;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Company;
use App\Models\Country;
use App\Models\Employe;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\SavedJob;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Traits\Api\ApiMethods;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobsListController extends Controller
{
    use ApiMethods;

    public function jobListing(Request $request)
    {
//        11. date range (from-to)
        $limit= $request->has("limit") ? $request->limit : 20;

        $user = null;
        $employee = null;
        if (auth()->guard('api')->user()) {
            $user = auth()->guard('api')->user();
        }

        if ($request->has("preferred_job")) {
            return $this->getUserPreferredJobs($user);
        }

        if ($request->has("saved_job")) {
            return $this->getUserSavedJobs($user);
        }


        $query =Job::query();
        $query->where('is_active', 1);
        $query->with([
            'company', 'company.country', 'company.state', 'company.city',
            'country',
            'education_level',
            'jobExperience',
            'job_category',
            'jobShift'
        ]);

        if($request->has("search_query")) {
            $searchTerm = $request->search_query;
            $query->where('title', 'LIKE', "%{$searchTerm}%");
            $query->orWhere('description', 'LIKE', "%{$searchTerm}%");
        }

        if($request->has("country_id")) {
            $query->where('country_id', $request->country_id);
        }

        if ($request->has("category_id")) {
            $query->where('job_categories_id', $request->category_id);
        }

        if ($request->has("company_id")) {
            $query->where('company_id', $request->company_id);
        }

        if ($request->has("expired_job") AND $request->has("expired_job") == 'true') {
            $query->where('is_expired', 1);
        }

        if ($request->has("active_job") AND $request->has("active_job") == 'true') {
            $query->where('status', 'Active');
        }

        if ($request->has("featured_job") AND $request->has("featured_job") == 'true') {
            $query->where('is_featured', 1);
        }

        if ($request->has("latest_job") AND $request->has("latest_job") == 'true') {
            $query->orderBy('id', 'desc');
        }

        $jobs = $query->paginate($limit);

        return $this->sendResponse(compact('jobs'),"success.");
    }

    public function getUserPreferredJobs($user)
    {
        if (!$user){
            return $this->sendResponse([],"Authentication token mismatch.", '', false);
        }
        $employee = Employe::where('user_id', $user->id)->first();
        $preferred_jobs = $employee->preferredJobs();
        return $this->sendResponse(compact('preferred_jobs'),"success");
    }

    public function getUserSavedJobs($user)
    {
        if (!$user){
            return $this->sendResponse([],"Authentication token mismatch.", '', false);
        }
        $employee = Employe::where('user_id', $user->id)->first();
        $saved_jobs = [];
        // 5 latest user saved jobs
        $saved_jobs_pivot = SavedJob::with([
            'job',
            'job.company',
            'job.country',
            'job.education_level',
            'job.jobExperience',
            'job.job_category',
            'job.jobShift',
        ])->where('employ_id', $employee->id)->get();

        if (!blank($saved_jobs_pivot)){
            foreach($saved_jobs_pivot as $value){
                $saved_jobs[] = $value->job;
            }
        }

        return $this->sendResponse(compact('saved_jobs'),"success");
    }

    public function applyJob(Request $request)
    {
        $validator = Validator::make($request->all(),  [
            'job_id' => 'required|int',
        ]);

        if($validator->fails()){
            return $this->sendResponse('', 'The given data was invalid', '', true);
        }

        $employee = Auth::guard('api')->user()->load('employee')->employee;

        if($employee AND $employee->calculateProfileCompletion() >= 50){
            try {

                if (JobApplication::where('employ_id', $employee->id)->where('job_id', $request->job_id)->exists()){
                    return $this->sendResponse('', 'Already applied for this job.', '', true);
                }

                $job_application = new JobApplication();
                $job_application->employ_id = $employee->id;
                $job_application->job_id = $request->job_id;
                $job_application->status = JobApplicationStatus::PENDING;
                $job_application->interview_status = JobApplicationInterviewStatus::NOT_STARTED;
                $job_application->save();

                return $this->sendResponse('', 'Successfully Applied for job.', '');
            }catch (\Exception $exception){
                return $this->sendResponse('', $exception->getMessage(), '', false);
            }
        }else{
            return $this->sendResponse('', 'Not eligible to apply.', '', false);
        }

    }

    public function listAppliedJob(Request $request)
    {
        $employee = Auth::guard('api')->user()->load('employee')->employee;

        if($employee){

            $query = JobApplication::query();
//            $query->where('employ_id', $employee->id)->with('job');
            $query->where('employ_id', $employee->id)->with(
                [
                    'job.company', 'job.company.country', 'job.company.state', 'job.company.city',
                    'job.country',
                    'job.education_level',
                    'job.jobExperience',
                    'job.job_category',
                    'job.jobShift'
                ]
            );

            if($request->has('status') AND !blank($request->status)){
                $query->where('status', $request->status);
            }

            $applications = $query->get()->groupBy('status');

            $application_list = [
                JobApplicationStatus::PENDING => $applications[JobApplicationStatus::PENDING] ?? null,
                JobApplicationStatus::SHORT_LISTED => $applications[JobApplicationStatus::SHORT_LISTED] ?? null,
                JobApplicationStatus::SELECTED_FOR_INTERVIEW => $applications[JobApplicationStatus::SELECTED_FOR_INTERVIEW] ?? null,
                JobApplicationStatus::INTERVIEWED => $applications[JobApplicationStatus::INTERVIEWED] ?? null,
                JobApplicationStatus::ACCEPTED => $applications[JobApplicationStatus::ACCEPTED] ?? null,
                JobApplicationStatus::REJECTED => $applications[JobApplicationStatus::REJECTED] ?? null,
                JobApplicationStatus::RED_LISTED => $applications[JobApplicationStatus::RED_LISTED] ?? null,
            ];

            return $this->sendResponse(compact('application_list'), 'success', '');
        }

        return $this->sendResponse('', 'Employee not found.', '', false);
    }

//    public function listing(Request $request){
//        // dd($request);
//        $limit= $request->has("limit")?$request->limit:10;
//        $jobs =Job::query();
//        $jobs->with(['company', 'country', 'job_category']);
//        if($request->has("is_active")){
//            $jobs->where('is_active',$request->is_active);
//        }
//        if($request->has("is_featured")){
//            $jobs->where('is_featured',$request->is_featured);
//        }
//        if($request->has("job_experience_id")){
//            $jobs->where('job_experience_id',$request->job_experience_id);
//        }
//        if($request->has("job_categories_id")){
//            $jobs->where('job_categories_id',$request->job_categories_id);
//        }
//        if($request->has("slug")){
//            $jobs->where('slug',$request->slug);
//        }
//        if($request->has("id")){
//            $jobs->where('id',$request->id);
//        }
//        if($request->has("only_latest")){
//            if($request->only_latest==true){
//                $t=time();
//                $jobs->where('expiry_date',">=",date("Y-m-d",$t));
//            }
//        }
//        if($request->has('country_id')){
//            $jobs->where('country_id',$request->country_id);
//        }
//        if($request->has('state_id')){
//            $jobs->where('state_id',$request->state_id);
//        }
//        if($request->has('city_id')){
//            $jobs->where('city_id',$request->city_id);
//        }
//        if($request->has('include_applied')){
//            if($request->include_applied){
//                $jobs->whereNotExists(function($query)
//                {
//                    $query->select(DB::raw(1))
//                        ->from('job_applications')
//                        ->whereRaw('jobs.id = job_applications.job_id');
//                });
//            }
//        }
//        $total_records=$jobs->count();
//        // dd($total_records);
//        if($request->has("page_no")){
//            $jobs->limit($limit)->offset($request->page_no>=1?($request->page_no-1)*10:1);
//        }else{
//            $jobs->limit($limit);
//        }
//
//        $j=$jobs->get();
//        // dd($j);
//        $results = [];
//        foreach($j as $index=>$job){
//            $results[$index] = $this->process($job);
//        }
//
//        // dd($total_records);
//        $total_page_no=(int)($total_records/$limit);
//        $page_no=$request->has("page_no")?$request->page_no:1;
//        $pagination=[
//            "total_records"=>(int)$total_records,
//            "total_pages"=>(int)$total_page_no,
//            "limit"=>(int)$limit,
//            "page_no"=>(int)$page_no,
//        ];
//        $page_no>1?
//            $pagination=array_merge(
//                $pagination,
//                ["previous"=>$page_no-1]
//            ):null;
//        $page_no<$total_page_no?
//            $pagination=array_merge(
//                $pagination,
//                ["next"=>$page_no+1]
//            ):null;
//        return $this->sendResponse($results,"Jobs List.",$pagination);
//    }

    public function process($job){
        $company=DB::table('companies')->find($job->company_id);
        $jobshifts=[];
        $job_shifts=DB::table("manage_job_shifts")->where("job_id",$job->id)->get();
        // dd($job_shifts);
        foreach($job_shifts as $index=>$shift){
            $jobshift= DB::table('job_shifts')->find($shift->job_shifts_id);
            if($jobshift){
                $jobshifts[$index]=
                    [
                        "id"=>(int)$jobshift->id,
                        "shift"=>$jobshift->job_shift
                    ];
            }
        }
        $educationlevels=DB::table('educationlevels')->find($job->education_level_id);
        $experiencelevels=DB::table('experiencelevels')->find($job->job_experience_id);
        $country=DB::table('countries')->find($job->country_id);

        // dd($country);
        $state=DB::table('states')->find($job->state_id);
        $city=DB::table('cities')->find($job->city_id);

        return [
            "id"=> (int)$job->id,
            "company"=>($company?[
                "id"=>(int)$company->id,
                "name"=>$company->company_name,
                "logo_url"=>env("APP_URL").$company->company_logo,
                "cover_image_url"=>env("APP_URL").$company->company_cover,
                "phone"=>$company->company_phone,
                "email"=>$company->company_email
            ]:null),
            "title"=> $job->title,
            "description"=> $job->description,
            "feature_image_url"=> env("APP_URL").$job->feature_image_url,
            "benefits"=>$job->benefits,
            "salary_from"=>(boolean)$job->hide_salary?0.0:floatval($job->salary_from),
            // "salary_from"=> (int)$job->hide_salary==1?$job->salary_from:"Hidden",
            "salary_to"=> (boolean)$job->hide_salary?0.0:floatval($job->salary_to),
            "hide_salary"=> (boolean)$job->hide_salary,
            "salary_currency"=>$job->salary_currency,
            "job_category"=>  @DB::table('job_categories')->find($job->job_categories_id)->functional_area,
            "job_shifts"=> $jobshifts,
            "country_id"=>$job->country_id,
            "num_of_positions"=> (int)$job->num_of_positions,
            "expiry_date"=> $job->expiry_date,
            "education_level"=>isset($educationlevels->title)?$educationlevels->title:"No Education Background.",
            "job_experience"=>isset($experiencelevels->title)?$experiencelevels->title:"Fresh",
            "site_location"=>[
                "country"=>[
                    "id"=>(int)$country->id,
                    "name"=>$country->name,
                    "country_code"=>$country->iso3,
                    "flag"=>$country->emoji
                ],
                "state"=>[
                    "id"=>(int)$state->id,
                    "name"=>$state->name,
                ],
                "city"=>[
                    "id"=>(int)$city->id,
                    "name"=>$city->name,
                ]
            ],
            "is_active"=> (boolean)$job->is_active,
            "is_featured"=>(boolean)$job->is_featured
            // "created_at"=> $job->created_at,
            // "updated_at"=> $job->updated_at,
        ];
    }

    public function getHome()
    {
        $banners = Banner::where('type', 'job')->where('is_active', 1)->get();

        // 10 countries order by number of jobs desc
        $countries = Country::has('jobs')->inRandomOrder()->limit(10)->get();

        // 5 categories
        $categories = JobCategory::has('jobs')->inRandomOrder()->limit(5)->get();

        // 5 latest jobs
        $new_jobs = Job::with(['company','company.country', 'company.state', 'company.city', 'country', 'education_level','jobExperience', 'job_category', 'jobShift'])->orderBy('id', 'desc')->limit(5)->get();

        $all_jobs = Job::with(['company','company.country', 'company.state', 'company.city', 'country', 'education_level','jobExperience', 'job_category', 'jobShift'])->inRandomOrder()->limit(5)->get();

        $featured_jobs = Job::where('is_featured', 1)->with(['company', 'country', 'education_level','jobExperience', 'job_category', 'jobShift'])->inRandomOrder()->limit(5)->get();

        // 5 companies
        $companies = Company::has('jobs')->with(['country', 'state', 'city'])->inRandomOrder()->limit(5)->get();

        // 5 featured jobs
//        $featured_jobs = $this->getFeaturedJobs();
//    )PHhKs]9(q.=
        $preferred_jobs= [];
        $saved_jobs= [];

        if (auth()->guard('api')->check()){
            $user = auth()->guard('api')->user();
            // 5 user preferred jobs
            $employee = Employe::where('user_id',  $user->id)->first();
            $preferred_jobs = $employee->preferredJobs();

            // 5 latest user saved jobs
            $saved_jobs_pivot = SavedJob::with([
                'job',
                'job.company',
                'job.country',
                'job.education_level',
                'job.jobExperience',
                'job.job_category',
                'job.jobShift',
            ])->where('employ_id', $employee->id)->limit(5)->get();
            if (!blank($saved_jobs_pivot)){
                foreach($saved_jobs_pivot as $value){
                    $saved_jobs[] = $value->job;
                }
            }
        }
        return $this->sendResponse(compact(
            'banners',
            'countries',
            'categories',
            'preferred_jobs',
            'new_jobs',
            'new_jobs',
            'all_jobs',
            'companies',
            'saved_jobs',
            'featured_jobs'
        ),"success");
    }


    public function getFeaturedJobs()
    {
        return [];
    }
}
