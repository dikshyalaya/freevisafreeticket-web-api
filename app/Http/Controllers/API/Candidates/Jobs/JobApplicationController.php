<?php

namespace App\Http\Controllers\API\Candidates\Jobs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Api\ApiMethods;
use DB;
use App\Models\Job;
use App\Models\Employe;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\Candidates\Jobs\JobsListController;

class JobApplicationController extends Controller
{
    use ApiMethods;
    public function __construct(){
        $this->jobcontroller=new JobsListController();
    }
    public function index($id){
        $employ=Employe::where([
            'user_id'=>Auth::user()->id
        ])->first();
        $application= DB::table('job_applications')->where([
            'employ_id'=>$employ->id
        ])->find($id);
        // dd($application);
        return $this->sendResponse([
            "application_id"=>$application,
            "job"=>$this->jobcontroller->process(Job::find($application->job_id))
        ],"Job Application Fetched.");

    }
    public function apply(Request $request){
        $request->validate([
            'job_id'=>'required|unique:job_applications'
        ]);
        $employ=Employe::where([
            'user_id'=>Auth::user()->id
        ])->first();
        $application= DB::table('job_applications')
        ->insertGetId(
            [
                'employ_id'=>$employ->id,
                'job_id'=>$request->job_id,
                'status'=>'onprocess',
                "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
                "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
        ]);
        // dd($application);
        return $this->sendResponse([
            "application_id"=>$application,
            "job"=>$this->jobcontroller->process(Job::find($request->job_id))
        ],"Job Application Submitted.");
    }
    public function list(Request $request){
        // dd($request);
        $jobs = [];
        $employ= DB::table('employes')->where('user_id',Auth::user()->id)->first();
        $job_applications= DB::table('job_applications')->where([
            'employ_id'=>$employ->id
        ])->where('status',$request->status)->get();
        
        foreach($job_applications as $index=>$application){
            $jobs[$index]=[
                "application_id"=>$application->id,
                "job"=>$this->jobcontroller->process(Job::find($application->job_id))
            ];
        }
        return $this->sendResponse($jobs,"Jobs Applications List.");
    }
}
