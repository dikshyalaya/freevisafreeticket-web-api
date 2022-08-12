<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Models\ApplicantFilter;
use Illuminate\Support\Facades\DB;
use App\Traits\Site\CompanyMethods;
use Illuminate\Support\Facades\Validator;

class ApplicantFilterController extends Controller
{
    use CompanyMethods;
    public function __construct()
    {

    }

    public function getApplicantFilter(Request $request)
    {
        try{
            $applicantFilter = ApplicantFilter::where("id", $request->applicantFilterId)->first();
            return response()->json(['applicantFilter' => $applicantFilter, "success" => true]);
        } catch(\Exception $e){
            return response()->json(['error' => $e->getMessage(), "success" => false]);
        }
    }

    public function saveFilter(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'filter_name' => ['required', 'unique:applicant_filters,filter_name'],
        ]);
        if($validator->fails()){
            return response()->json(['success' => false,'errors' => $validator->errors()]);
        }
        try{
            DB::beginTransaction();
            $datas = [];
            $datas[] = [
                'job_title' => $request->job_title,
                'gender' => $request->gender,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'experience' => $request->experience,
                'education_level' => $request->education_level,
                'application_status' => $request->application_status,
                'profile_score' => $request->profile_score,
                'min_age' => $request->min_age,
                'max_age' => $request->max_age,
                'skills' => !blank($request->skills) ? json_encode($request->skills) : null,
                'trainings' => !blank($request->trainings) ? json_encode($request->trainings) : null,
                'languages' => !blank($request->languages) ? json_encode($request->languages) : null,
                'preferred_jobs' => !blank($request->preferred_jobs) ? json_encode($request->preferred_jobs) : null,
                'preferred_countries' => !blank($request->preferred_countries) ? json_encode($request->preferred_countries) : null,

            ];
            $applicant_filter = ApplicantFilter::create([
                'filter_name' => $request->filter_name,
                'filter_value' => json_encode($datas),
            ]);
            DB::commit();
            return response()->json(['success' => true, 'msg' => 'Filter saved successfully']);
        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['success' => false, 'db_error' => $e->getMessage()]);
        }
    }

    public function getAdvancedSearchData(Request $request)
    {
        $applicants = JobApplication::query();
        $applicants = $applicants->when(!blank($request->application_status), function($q) use($request){
            $q->orWhere('status', $request->application_status);
        })->when(!blank($request->from_date) AND blank($request->to_date), function($q) use($request){
            $q->where(DB::raw('CAST(created_at as date)'), $request->from_date);
        })->when(!blank($request->to_date) AND blank($request->from_date), function($q) use($request){
            $q->where(DB::raw('CAST(created_at as date)'), $request->to_date);
        })->when(!blank($request->from_date) AND !blank($request->to_date), function($q) use($request){
            $q->orWhereBetween(DB::raw('CAST(created_at as date)'), [$request->from_date, $request->to_date]);
        })->whereHas('employe', function($query) use($request){
            return $query->when(!blank($request->gender), function($q) use($request){
                $q->where('gender', $request->gender);
            });
            // ->whereHas('countryPreference', function($query2) use($query, $request){
            //     $query2->when(!blank($request->preferred_countries), function($q) use($query, $request){
            //         $query->orWhereIn('country_id', $request->preferred_countries);
            //     });
            // });
        })->whereHas('job', function($query3) use($request){
            return $query3->when(!blank($request->job_title), function($q) use($request){
                $q->orWhere('job_categories_id', $request->job_title);
            })->when(!blank($request->preferred_jobs), function($q) use($request){
                $q->orWhereIn('job_categories_id', $request->preferred_jobs);
            })->when(!blank($request->min_age) AND blank($request->max_age), function($q) use($request){
                $q->orWhere('min_age', $request->min_age);
            })->when(!blank($request->max_age) AND blank($request->min_age), function($q) use($request){
                $q->orWhere('max_age', $request->max_age);
            })->When(!blank($request->min_age) AND !blank($request->max_age), function($q) use($request){
                $q->orWhere('min_age', $request->min_age)->orWhere('max_age', $request->max_age);
            })->when(!blank($request->preferred_countries), function($q) use($request){
                $q->orWhereIn('country_id', $request->preferred_countries);
            });
        })->with(['employe', 'job'])->paginate(4);
        $sn = ($applicants->perPage() * ($applicants->currentPage() - 1)) + 1;
        return $this->company_view('company.newapplicant.advancedSearchResult',[
            "applicants" => $applicants,
            "sn" => $sn,
            "pagination" => $applicants->appends([
                "job_title" => $request->job_title,
                "gender" => $request->gender,
                "from_date" => $request->from_date,
                "to_date" => $request->to_date,
                "experience" => $request->experience,
                "education_level" => $request->education_level,
                "skills" => $request->skills,
                "application_status" => $request->application_status,
                "profile_score" => $request->profile_score,
                "min_age" => $request->min_age,
                "max_age" => $request->max_age,
                "trainings" => $request->trainings,
                "languages" => $request->languages,
                "preferred_jobs" => $request->preferred_jobs,
                "preferred_countries" => $request->preferred_countries,
            ]),
        ]);
        // echo "<pre>";
        // print_r($applicants);
        // echo "</pre>";
        // die();
        // print_r(json_encode($applicants, JSON_PRETTY_PRINT));
    }


    public function filterByTitleCountryCompany(Request $request)
    {

    }
}
