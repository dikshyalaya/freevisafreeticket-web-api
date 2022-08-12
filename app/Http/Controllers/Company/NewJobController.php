<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\EducationLevel;
use App\Models\ExperienceLevel;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\JobShift;
use App\Models\Skill;
use App\Notifications\NewJob;
use App\Traits\Site\CompanyMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NewJobController extends Controller
{
    use CompanyMethods;

    public function __construct()
    {
        $GLOBALS['page-name'] = 'Job';
        $this->experiencelevels = ExperienceLevel::get();
        $this->educationlevels = EducationLevel::get();
        $this->job_shifts = JobShift::get();
        $this->job_categories = JobCategory::get();
        $this->countries = Country::get();
        $this->job_session = 'job_detail';
    }

    public function get_job_detail(Request $request)
    {
        $company = $this->company();
        if((int) $company->calculateProfileCompletion() < 50){
            return redirect()->route('company.edit_profile')->with(notifyMsg('error', 'Complete your profile before posting new job'));
        }
        $job = Job::where('id', $request->job_id)->first();
        return $this->company_view('company.newjob.get_job', [
            'job' => $job,
            'job_categories' => $this->job_categories,
            'countries' => $this->countries,
            'editRoute' => $request->editRoute,
        ]);
    }
    private $destination = 'uploads/jobs/';

    public function postJobDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'company_id' => ['required'],
            // 'male_employee' => ['required'],
            // 'female_employee' => ['required'],
            'any_employee' => ['nullable'],
            'feature_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:4096'],
            'category_id' => ['required'],
            'working_hours' => ['required'],
            'working_days' => ['required'],
            'contract_year' => ['required'],
            'contract_month' => ['nullable'],
            'country' => ['required'],
            'state' => ['required'],
        ], [
            'company_id.required' => 'Company is required',
            'category_id.required' => 'Category is required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        if ($validator->passes()) {
            try{
                DB::beginTransaction();
                $j = Job::where('id', $request->job_id)->first();
                $oldImage = $j != null ? $j->feature_image_url : '';
                if ($request->has('feature_image')) {
                    $image = $request->file('feature_image');
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $feature_image_url = $this->destination . $imageName;
                    $image->move(public_path($this->destination, 'public'), $imageName);
                } 
                $job = Job::updateOrCreate(
                    ['id' => $request->job_id],
                    [
                        'title' => $request->title,
                        'company_id' => $request->company_id,
                        'no_of_male' => $request->male_employee,
                        'no_of_female' => $request->female_employee,
                        'any_gender' => $request->any_employee,
                        'num_of_positions' => $request->male_employee + $request->female_employee + $request->any_employee,
                        'job_categories_id' => $request->category_id,
                        'working_hours' => $request->working_hours,
                        'working_days' => $request->working_days,
                        'expiry_date' => $request->deadline,
                        'country_id' => $request->country,
                        'state_id' => $request->state,
                        'city_id' => $request->city_id,
                        'contract_year' => $request->contract_year,
                        'contract_month' => $request->contract_month,
                        'description' => $request->job_description,
                        'description_intro' => $request->job_description_intro,
                        'feature_image_url' => $request->has('feature_image') ? $feature_image_url : $oldImage,
                        'is_active' => 0,
                        'is_featured' => 0,
                        // 'status' => $request->status == null ? 'Pending' : $request->status,
                    ]
                );
                $redirectTo = route('company.newjob.get_applicant_form',['job_id' => $job->id]);
                DB::commit();
                return response()->json(['redirectRoute' => $redirectTo]);
            } catch(\Exception $e){
                DB::rollBack();
                return response()->json(['db_error' => $e->getMessage()]);
            }
            
        }
    }

    public function get_applicant_form(Request $request)
    {
        $job = Job::where('id', $request->job_id)->first();
        return $this->company_view('company.newjob.get_applicant_form', [
            'job' => $job,
            "educationlevels" => $this->educationlevels,
            'skills' => Skill::get(),
            'editRoute' => $request->editRoute,
        ]);
    }

    public function post_applicant_form(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'education_level' => ['required'],
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }

        if($validator->passes()){
            try{
                DB::beginTransaction();
                $job = Job::find($request->job_id);
                if (!empty($request->skills)) {
                    foreach ($request->skills as $key => $skill) {
                        $skillData[] = $skill;
                    }
                    $skills = json_encode($skillData);
                }
                $job->update([
                    'education_level_id' => $request->education_level,
                    'min_experience' => $request->min_experience,
                    'max_experience' => $request->max_experience,
                    'min_age' => $request->min_age,
                    'max_age' => $request->max_age,
                    'requirements' => $request->other_requirements,
                    'requirement_intro' => $request->requirement_intro,
                    'skills' => !empty($request->skills) ? $skills : '',
                ]);
                DB::commit();
                $redirectTo = route('company.newjob.get_salary_and_facility_form', ['job_id' => $job->id]);
                return response()->json(['redirectRoute' => $redirectTo]);
            } catch(\Exception $e){
                DB::rollBack();
                return response()->json(['db_error' => $e->getMessage()]);
            }
        }
    }

    public function get_salary_and_facility_form(Request $request)
    {
        $job = Job::where('id', $request->job_id)->first();
        // $currency = Country::where("id", $job->country_id)->first()->currency ?? 'NPR';
        $currency = Country::where("id",  $job->country_id)->value('currency') ?? 'NPR';
        // dd($currency);
        // $country = Country::where('id', $job->country_id)->first();
        // $currency = $country != null ? $country->currency : 'NPR';
        return $this->company_view('company.newjob.get_salary_and_facility_form', [
            'job' => $job,
            'currency' => $currency,
            'editRoute' => $request->editRoute,
        ]);
    }

    public function post_salary_and_facility(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'accomodation' => ['required'],
            'food' => ['required'],
            'annual_vacation' => ['required'],
            'over_time' => ['required'],
            'country_salary' => ['required'],
            'nepali_salary' => ['required'],
        ],[
            'country_salary.required' => 'The Salary field is required',
            'nepali_salary.required' => 'The Salary field is required',
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }
        if($validator->passes()){
            try{
                DB::beginTransaction();
                $job = Job::find($request->job_id);
                $job->update([
                    'country_salary' => $request->country_salary,
                    'nepali_salary' => $request->nepali_salary,
                    'earning_country_salary' => $request->earning_country_salary,
                    'earning_nepali_salary' => $request->earning_nepali_salary,
                    'accomodation' => $request->accomodation,
                    'food' => $request->food,
                    'annual_vacation' => $request->annual_vacation,
                    'over_time' => $request->over_time,
                    'benefits' => $request->other_benefits,
                    'benefit_intro' => $request->benefit_intro,
                    'hide_salary' => $request->hide_salary != null ? 1 : 0,
                ]);
                DB::commit();
                $redirectTo = route('company.newjob.get_job_preview', ['job_id' => $job->id]);
                return response()->json(['redirectRoute' => $redirectTo]);
            } catch(\Exception $e){
                DB::rollBack();
                return response()->json(['db_error' => $e->getMessage()]);
            }
        }

    }

    public function get_job_preview(Request $request)
    {
        $job = Job::where("id", $request->job_id)->with(['company', 'job_category', 'country', 'education_level'])->first();
        return $this->company_view('company.newjob.get_job_preview',[
            'job' => $job,
            'editRoute' => $request->editRoute,
        ]);
    }

    public function get_approval_form(Request $request)
    {
        $job = Job::find($request->job_id);
        return $this->company_view('company.newjob.get_approval_form',[
            'job' => $job,
            'editRoute' => $request->editRoute,
        ]);
    }

    public function post_approval_form(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'job_id' => ['required'],
        ], [
            'job_id.required' => 'Job is not found',
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }
        if($validator->passes()){
            try{
                DB::beginTransaction();
                $job = Job::find($request->job_id);
                $oldStatus = $job->status;
                $fields = [];
                if($request->saveType == "save_as_draft"){
                    $fields['status'] = 'Draft';
                    $fields['draft_date'] = date('Y-m-d H:i:s');
                } else if($request->saveType == 'proceed_to_approval'){
                    $fields['status'] = 'Pending';
                } else if($request->saveType == 'update'){
                    $fields['status'] = $request->status != null ? $request->status : $oldStatus;
                }
                $job->update([
                    'status' => $request->saveType == 'save_as_draft' ? 'Draft' : 'Pending',
                    'draft_date' => $request->saveType == 'save_as_draft' ? date('Y-m-d H:i:s') : null,
                ]);
                DB::commit();
                $notification['msg'] = "New job created";
                $notification['link'] = route('viewJob', $request->job_id);
                $notification['detail'] = '';
                $delay = now()->addSeconds(5);
                auth()->user()->notify((new NewJob($notification))->delay($delay));
                $msg = $request->saveType == "save_as_draft" ? 'Your job has been saved and you can proceed to approval at any time. Thank you' : 'Your job has been send to admin for verification. Your job will be posted automatically after the verification. Thank you';
                return response()->json(['msg' => $msg, 'redirectRoute' => route('company.jobs')]);
            } catch(\Exception $e){
                DB::rollBack();
                return response()->json(['db_error' => $e->getMessage()]);
            }
        }
    }

}
