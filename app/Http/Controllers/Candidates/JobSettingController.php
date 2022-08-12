<?php

namespace App\Http\Controllers\Candidates;

use App\Models\Country;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use App\Traits\Site\ThemeMethods;
use App\Http\Controllers\Controller;
use App\Models\EmployJobPreference;
use App\Traits\Site\CandidateMethods;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JobSettingController extends Controller
{
    use ThemeMethods, CandidateMethods;

    private $page = 'candidates.setting.job_setting.';
    public function __construct()
    {
        $this->job_categories = JobCategory::get();
        $this->country = Country::select('id', 'name')->get();
    }

    public function get_job_preference()
    {
        return $this->client_view($this->page."get_job_preference");
        
    }

    public function get_job_alert()
    {
        return $this->client_view($this->page."get_job_alert");
        
    }

    public function post_job_preference(Request $request)
    {
        // $validator = Validator::make($request->all(),[
        //     'countries.*' => ['required'],
        //     'categories.*' => ['required'],
        //     'job_title.*' => ['required'],
        // ]);
        try{
            DB::beginTransaction();
            if(in_array(!null, $request->categories) || in_array(!null, $request->countries) || in_array(!null, $request->job_title)){
                $preferences = EmployJobPreference::where('employ_id', $this->employe()->id);
                if($preferences->exists()){
                    $preferences->delete();
                }
                
                $this->employe()->update([
                    'job_notify' => $request->has('job_notify') ? 1 : 0,
                ]);
               

                foreach($request->categories as $key => $category){
                    if($category != null){
                        EmployJobPreference::create([
                            'employ_id' => $this->employe()->id,
                            'job_category_id' => $category,
                        ]);
                    }
                }
                foreach($request->countries as $key => $country){
                    if($country != null){
                        EmployJobPreference::create([
                            'country_id' => $country,
                            'employ_id' => $this->employe()->id,
                        ]);
                    }
                }
                foreach($request->job_title as $key => $job_title){
                    if($job_title != null){
                        EmployJobPreference::create([
                            'job_title' => $job_title,
                            'employ_id' => $this->employe()->id,
                        ]);
                    }
                }
            }
           
            DB::commit();
            return response()->json(['msg' => 'Job Preference updated successfully', 'redirectRoute' => route('candidate.job_setting.index')]);
        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['db_error' => $e->getMessage()]);
        }
    }


    public function updateJobNotification(Request $request)
    {
        if($request->notify == 'job_notify'){
            $this->employe()->update([
                'job_notify' => $request->name == 1 ? 0 : 1,
            ]);
            $job_notify = $this->employe()->refresh()->job_notify;
            $msg = $job_notify == 1 ? 'Job notification for preferred job enabled' : 'Job notification for preferred job disabled';
            return response()->json(['msg' => $msg, 'value' => $job_notify]);
        } 
        if($request->notify == 'all_job_notify'){
            $this->employe()->update([
                'all_job_notify' => $request->name == 1 ? 0 : 1,
            ]);
            $all_job_notify = $this->employe()->all_job_notify;
            $msg = $all_job_notify == 1 ? 'All job notification enabled' : 'All job notification disabled';
            return response()->json(['msg' => $msg, 'value' => $all_job_notify]);
        }
    }
    
}
