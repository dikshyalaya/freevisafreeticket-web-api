<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Employe;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\JobView;
use App\Traits\Site\ThemeMethods;
use DB;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    use ThemeMethods;
    public function index(Request $request)
    {
        // $jobs = new Job();
        $jobs = Job::whereIn('status', ['Active', 'Published', 'Approved']);
        global $search;
        // dd($search);
        if ($request->filled('search')) {
            $search = $request->search;
            $categories = JobCategory::where('functional_area', 'LIKE', '%' . $search . '%')->pluck('id')->toArray();
            $jobs = $jobs->where(function ($jobs) use ($search, $categories) {
                // global $search;
                $jobs->where('title', 'LIKE', '%' . $search . '%')->orWhereIn('job_categories_id', $categories);
            });
        }
        if ($request->filled('country_id') && $request->country_id != 'All Countries') {
            $jobs = $jobs->where('country_id', $request->country_id);
        }
        if ($request->filled("job_catagory") && $request->job_catagory != 'All Categories') {
            // foreach ($request->job_category as $item) {
            //     $jobs = $jobs->where('job_categories_id', $item);
            // }
            $jobs = $jobs->whereIn('job_categories_id', (array) $request->job_catagory);
        }
        // dd($jobs->where('job_categories_id', $request->job_category)->get());
        // $request->filled("salary_from") ? $jobs->where('salary_from', ">=", $request->salary_from) : null;
        // $request->filled("salary_to") ? $jobs->where('salary_to', "<=", $request->salary_to) : null;
        $job_categories = JobCategory::get();
        $job_shifts = DB::table('job_shifts')->get();
        $jobs = $jobs->orderBy('id', 'desc')->with(['company', 'country', 'job_category'])->paginate(9)->setPath('');
        $fields = [
            "jobs" => $jobs,
            "pagination" => $jobs->appends(array(
                'search' => $request->search,
                'country_id' => $request->country_id,
                'job_catagory' => $request->job_catagory,
                'salary_from' => $request->salary_from,
                'salary_to' => $request->salary_to,

            )),
            "job_categories" => $job_categories,
            "job_shifts" => $job_shifts,
        ];
        if (auth()->check() && auth()->user()->user_type == "candidate") {
            $employ = Employe::where('user_id', auth()->user()->id)->first();
            $job_preference = DB::table('employ_job_preference')->where('employ_id', $employ->id)->first();
            $fields['job_preference'] = $job_preference;
            $fields['employ'] = $employ;
        }
        return $this->site_view("site.jobs", $fields);
    }
    public function jobindex($id)
    {
        $job = Job::find($id);
        if ($job) {
            $company = Company::where('id', $job->company_id)->first();
            $company_contact_persons = DB::table('company_contact_persons')->where('company_id', $job->company_id)->first();
            $fields = [
                "job" => Job::where('id', $id)->with('company', 'country', 'job_category')->first(),
                "company_contact_persons" => $company_contact_persons,
                "company" => $company,
            ];
            if (auth()->check() && auth()->user()->user_type == "candidate") {
                $employ = Employe::where('user_id', auth()->user()->id)->with('employeeSkills')->first();
                $application = DB::table('job_applications')->where('job_id', $id)->where('employ_id', $employ->id)->first();
                $fields['application'] = $application;
                $fields['employ'] = $employ;
            }
            return $this->site_view("site.job_view", $fields);
        } else {
            return abort(404);
        }
    }

    public function storeJobView(Request $request)
    {
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $job = Job::where('id',$request->job_id)->first();
        $jobView = JobView::firstOrCreate([
            'job_id' => $request->job_id,
            'fingerprint' => $request->fingerprint,
            'view_date' => $date,
        ], [
            'job_id' => $request->job_id,
            'fingerprint' => $request->fingerprint,
            'useragent' => $request->useragent,
            'browser' => $request->browser,
            'timezone' => $request->timezone,
            'view_date' => $date,
            'view_time' => $time,
        ]);
        if($jobView->wasRecentlyCreated === true){ // item was not found and created in database;
            // Job::find($request->job_id)->update(['total_views' => $job->total_views + 1]);
            $job->increment('total_views'); 
            return response()->json(['message' => 'View created']);
        }
        return response()->json(['message' => 'View Already Created']);
    }
}
