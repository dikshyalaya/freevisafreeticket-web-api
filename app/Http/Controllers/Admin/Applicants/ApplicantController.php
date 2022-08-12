<?php

namespace App\Http\Controllers\Admin\Applicants;

use DB;
use App\Models\Job;
use App\Models\User;
use App\Models\Country;
use App\Models\Employe;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Traits\Admin\AdminMethods;
use App\Models\EmployJobPreference;
use App\Http\Controllers\Controller;

class ApplicantController extends Controller
{
    use AdminMethods;
    public function __construct(){

        $this->countries=Country::where('is_active', 1)->get();
    }
    public function list(){
        // $applicants = JobApplication::whereHas('job', function($q){
        //     return $q->with('company');
        // })->paginate(10);
        $applicants = JobApplication::with(['employe:id,user_id,first_name,middle_name,last_name,mobile_phone,country_id','employe.user:id,email','employe.country:id,name','job.company:id,company_name'])->paginate(10);
        $sn = ($applicants->perPage() * ($applicants->currentPage() - 1)) + 1;
        return $this->view('admin.pages.applicants.list',[
            'applicants'=>$applicants,
            'sn' => $sn
            // 'applicants'=>JobApplication::paginate(10)
        ]);
    }
    public function new(){
        return $this->view('admin.pages.applicants.editadd',[
            'action'=>"New",
            'countries'=>$this->countries
        ]);
    }
    public function edit($id){
        $job_categories=JobCategory::get();
        // $job_categories=DB::table('job_categories')->get();
        $application=JobApplication::find($id);
        $candidate =Employe::find($application->employ_id);
        $job=Job::find($application->job_id);
        $job_preference=EmployJobPreference::where('employ_id',$application->employ_id)->first();
        // dd($candidate->id);
        // dd(User::find($candidate->user_id));
        // return redirect()->route('admin.applicant.indexpage')->with(notifyMsg('success', 'Applicant updated successfully'));
        return $this->view('admin.pages.applicants.editadd',[
            'candidate'=>$candidate,
            'job'=>$job,
            'application'=>$application,
            'action'=>"Edit",
            'candidate_user'=>User::find($candidate->user_id),
            'countries'=>$this->countries,
            'job_categories'=>$job_categories,
            'job_preference'=>$job_preference
        ]);
    }
    public function save(Request $request){
        $fields=[];
        $preferences=[];
        //Job Application
        $request->has("employ_id")?$fields["employ_id"]=$request->employ_id:null;
        $request->has("job_id")?$fields["job_id"]=$request->job_id:null;
        $request->has("status")?$fields["status"]=$request->status:null;
        $request->has("interview_status")?$fields["interview_status"]=$request->interview_status:null;
        $request->has("interview_date")?$fields["interview_date"]=$request->interview_date:null;
        $request->has("interview_time")?$fields["interview_time"]=$request->interview_time:null;
        // Job Preference
        $request->has("country_id")?$preferences["country_id"]=$request->country_id:null;
        $request->has("category")?$preferences["job_category_id"]=$request->category:null;

        \DB::table('job_applications')->updateOrInsert(['id'=>$request->application_id],$fields);
        return redirect()->route('admin.applicant.indexpage')->with(notifyMsg('success', 'Applicant saved'));
        // EmployJobPreference::updateOrCreate(['employ_id'=>$request->employ_id],$preferences);
        // return $this->edit($request->application_id);
    }
    public function delete($id){
        try {
            $applicant = JobApplication::find($id);
            if($applicant != null){
                $applicant->delete();
                return redirect()->back()->with(notifyMsg('success', 'Applicant deleted successfully'));
            }
            return redirect()->back()->with(notifyMsg('error', 'Applicant Not Found'));
            // DB::table('job_applications')->delete($id);
            // return redirect()
            // ->route('admin.applicants.list')
            // ->with(['delete'=>[
            //     'status' => 'success'
            // ]]);
        } catch (\Exception $e) {
            return redirect()->back()->with(notifyMsg('error', $e->getMessage()));
            // return redirect()
            // ->route('admin.applicants.list')
            // ->with(['delete'=>[
            //     'status' => 'failed'
            // ]]);
        }
    }
}
