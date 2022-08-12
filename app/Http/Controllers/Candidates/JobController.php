<?php

namespace App\Http\Controllers\Candidates;

use App\Models\Job;
use App\Models\Company;
use App\Models\Employe;
use App\Models\SavedJob;
use Illuminate\Http\Request;
use App\Traits\Site\ThemeMethods;
use App\Models\EmployJobPreference;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\Site\CandidateMethods;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Auth\Access\AuthorizationException;

class JobController extends Controller
{
    use ThemeMethods;
    use CandidateMethods;

    private $page = 'candidates.job.';

    public function saveJobLists()
    {
        $employe=@Employe::where('user_id',Auth::user()->id)->first();
        $saved_jobs = SavedJob::where('employ_id', $employe->id)->with(['job.company', 'job.country', 'job.job_category'])->latest()->paginate(10);
        return $this->site_view($this->page.'savedjobs',['saved_jobs' => $saved_jobs, 'employe' => $employe, 'employ' => $employe]);
    }

    public function saveJob(Request $request)
    {
        try {
            if(auth()->check() && auth()->user()->user_type == 'candidate'){
                if($request->job_id != null && $request->employ_id != null){
                    if(SavedJob::where('employ_id', $request->employ_id)->where('job_id', $request->job_id)->exists()){
                        SavedJob::where('employ_id', $request->employ_id)->where('job_id', $request->job_id)->delete();
                        return response()->json(['msg' => 'You unsaved job successfully', 'status' => 'delete']);
                        // return response()->json(['error' => 'This job is already saved on your profile']);
                    }
                    $saveJob = SavedJob::create([
                        'employ_id' => $request->employ_id,
                        'job_id' => $request->job_id,
                    ]);
                    return response()->json(['msg' => 'Job saved to your profile successfully.', 'status' => 'saved']);
                } else {
                    return response()->json(['error' => 'Something went wrong']);
                }
            } else {
                return response()->json(['redirectRoute' => route('candidate.login')]);
            }
        } catch (\Exception $e) {
            return response()->json(['db_error' => $e->getMessage()]);
        } catch (UnauthorizedException $ex){
            return response()->json(['redirectRoute' => route('candidate.login')]);
        }

    }

    public function unsaveJob(Request $request)
    {
        try{
            if(auth()->check() && auth()->user()->user_type=='candidate'){
                if($request->job_id != null && $request->employ_id != null){
                    if(SavedJob::where('employ_id', $request->employ_id)->where('job_id', $request->job_id)->exists()){

                    }
                }
            }
        } catch(\Exception $e){
            return response()->json(['db_error' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        SavedJob::destroy($id);
        return redirect()->back()->with(notifyMsg('warning', 'Saved Job deleted'));
    }


    public function recommended_job()
    {
        $employe=@Employe::where('user_id',Auth::user()->id)->first();
        // dd($employe);
        // $recommended_jobs = Job::whereHas("job_applications.employe", function($query) use($employe){
        //     return $query->whereHas('job_preference', function($q2) use($employe) {
        //         return $q2->where('job_categories_id', $employe->job_preference->job_category_id)
        //         ->where('country_id', $employe->job_preference->country_id);
        //     });
        // })->paginate(10); //Todo Check Query
        if(!empty($employe->job_preferences)){
            $industry_preferences = $this->employe()->industryPreference()->pluck('job_preference_id')->toArray();
            $job_category_preferences = $this->employe()->jobCategoryPreference()->pluck('job_preference_id')->toArray();
            $country_preferences = $this->employe()->countryPreference()->pluck('job_preference_id')->toArray();
            $recommended_jobs = Job::whereIn('job_categories_id', $job_category_preferences)
            ->orWhereIn('country_id', $country_preferences)
            ->when($industry_preferences, function($q) use ($industry_preferences){
                $companies = Company::whereIn('industry_id', $industry_preferences)->pluck('id')->toArray();
                $q->orWhereIn('company_id', $companies);
            })
            ->paginate(10);
        } else {
            $recommended_jobs = null;
        }
        return $this->site_view($this->page.'recommended_job', ['recommended_jobs' => $recommended_jobs, 'employe' => $employe]);
    }
}
