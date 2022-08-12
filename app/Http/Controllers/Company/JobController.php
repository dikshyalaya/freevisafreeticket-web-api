<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Job;
use App\Traits\Site\CompanyMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    use CompanyMethods;

    public function __construct()
    {
        $GLOBALS['page-name'] = "Job";
        $this->experiencelevels = DB::table('experiencelevels')->get();
        $this->educationlevels = DB::table('educationlevels')->get();
        $this->job_shifts = DB::table('job_shifts')->get();
        $this->job_categories = DB::table('job_categories')->get();
        $this->countries = \DB::table('countries')->where('is_active', 1)->get();
    }

    public function addNewJob()
    {
        return $this->company_view('company.job.addNewJob', [
            "experiencelevels" => $this->experiencelevels,
            "job_shifts" => $this->job_shifts,
            "job_categories" => $this->job_categories,
            "educationlevels" => $this->educationlevels,
            "countries" => $this->countries,
            'skills' => DB::table('skills')->get(),
        ]);
    }

    private $redirectTo = 'company.jobs';
    private $destination = 'uploads/jobs/';
    private $picturedestination = 'uploads/jobs/pictures/';

    public function saveNewJob(Request $request)
    {
        $validator = $this->__validation($request->all());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $job = new Job();
                $this->__saveOrUpdateJob($job, $request, '', '');
                if($request->saveType == 'save_as_draft'){
                    $job->status = 'Draft';
                    $job->draft_date = date('Y-m-d H:i:s');
                } else {
                    $job->status = 'Pending';
                }
                // $job->status = 'Not Approved';
                $job->draft_status = $request->saveType == 'save_as_draft' ? 1 : 0;
                $job->save();
                if($request->saveType == "save_and_preview"){
                    $this->redirectTo = "company.viewjob,".$job->id;
                }
                DB::commit();
                $msg = $request->saveType == 'save_as_draft' ? 'Your job added to draft' : 'New job added';
                if($request->saveType == "save_and_preview"){
                    return response()->json(['msg' => $msg, 'redirectRoute' => route('company.viewjob', $job->id)]);
                }
                return response()->json(['msg' => $msg, 'redirectRoute' => route($this->redirectTo)]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['db_error' => $e->getMessage()]);
            }
        }
    }

    public function edit($id)
    {
        $job = Job::findOrFail($id);
        $fields = [
            "job" => $job,
            "experiencelevels" => $this->experiencelevels,
            "job_shifts" => $this->job_shifts,
            "job_categories" => $this->job_categories,
            "educationlevels" => $this->educationlevels,
            "countries" => $this->countries,
            'skills' => DB::table('skills')->get(),
        ];
        // return $this->company_view('company.newjob.get_job', $fields);
        return $this->company_view('company.job.editjob', $fields);
    }

    public function updateJob(Request $request, $id)
    {
        $validator = $this->__validation($request->all());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $job = Job::find($id);
                $oldImage = $job->feature_image_url;
                $oldPicture = $job->pictures;
                $oldStatus = $job->status;
                $oldDraftStatus = $job->draft_status;
                $this->__saveOrUpdateJob($job, $request, $oldImage, $oldPicture);
                $job->status = $request->status != null ? $request->status : ($oldStatus == null ? 'Draft' : $oldStatus);
                if($request->status == 'Published'){
                    $job->publish_status = date('Y-m-d H:i:s');
                }
                $job->publish_status = $request->publish_status != null ? 1 : 0;
                $job->draft_status = $request->saveType == 'save_draft_job' ? 0 : $oldDraftStatus;
                if($request->saveType == 'save_draft_job'){
                    $job->status = 'Pending';
                }
                $job->save();
                DB::commit();
                return response()->json(['msg' => 'Job updated successfully', 'redirectRoute' => route($this->redirectTo)]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['db_error' => $e->getMessage()]);
            }
        }
    }

    public function viewjob($id)
    {
        $job = Job::findOrFail($id);
        return $this->company_view('company.job.viewjob', ['job' => $job]);
    }

    public function cloneJob($id)
    {
        try {
            $job = Job::findOrFail($id);
            $cloneJob = $job->replicate();
            $cloneJob->expiry_date = null;
            $cloneJob->is_active = 0;
            $cloneJob->is_featured = 0;
            $cloneJob->created_at = date('Y-m-d H:i:s');
            $cloneJob->updated_at = date('Y-m-d H:i:s');
            $cloneJob->status = 'Pending';
            $cloneJob->publish_status = 0;
            $cloneJob->approval_status = 0;
            $cloneJob->is_expired = 0;
            $cloneJob->save();
            return response()->json(['msg' => 'Job cloned successfully', 'redirectRoute' => route($this->redirectTo)]);
        } catch (\Exception $e) {
            return response()->json(['exception' => $e->getMessage()]);
        }

    }

    private function __validation(array $data)
    {
        return Validator::make($data, [
            'title' => ['required'],
            'company_id' => ['required'],
            'male_employee' => ['required'],
            'female_employee' => ['required'],
            'any_employee' => ['nullable'],
            'feature_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:4096'],
            // 'picture.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg'],
            'category_id' => ['required'],
            'education_level' => ['required'],
            'working_hours' => ['required'],
            'working_days' => ['required'],
            'contract_year' => ['required'],
            'contract_month' => ['required'],
            'accomodation' => ['required'],
            'food' => ['required'],
            'annual_vacation' => ['required'],
            'over_time' => ['required'],
            'country_salary' => ['required'],
            'nepali_salary' => ['required'],
            'country' => ['required'],
            'state' => ['required'],
        ], [
            'company_id.required' => 'Company is required',
            'category_id.required' => 'Category is required',
            'category.required' => 'Job Category is required',
            'education_level.required' => 'Education level is required',
            'experiencelevel.required' => 'Experience Level is required',
            'country_salary.required' => 'The Salary field is required',
            'nepali_salary.required' => 'The Nepali Salary field is required',
        ]);
    }

    private function __saveOrUpdateJob($job, $request, $oldImage = '', $oldpicture = '')
    {
        $job->company_id = $request->company_id;
        $job->title = $request->title;
        $job->description = $request->job_description;
        $job->description_intro = $request->job_description_intro;
        if($request->has('feature_image')){
            $image = $request->file('feature_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $job->feature_image_url = $this->destination . $imageName;
            $image->move(public_path($this->destination, 'public'), $imageName);
        } else {
            $job->feature_image_url = $oldImage;
        }

        $job->benefits = $request->other_benefits;
        $job->salary_from = $request->salary_from;
        $job->salary_to = $request->salary_to;
        $job->hide_salary = $request->hide_salary != null ? 1 : 0;
        $job->salary_currency = null;
        $job->job_categories_id = $request->category_id;
        $job->job_shift_id = $request->job_shift;
        $job->num_of_positions = $request->male_employee + $request->female_employee + $request->any_employee;
        $job->expiry_date = $request->deadline;
        $job->education_level_id = $request->education_level;
        $job->job_experience_id = $request->experiencelevel;
        $job->is_active = $request->is_active != null ? 1 : 0;
        $job->is_featured = $request->is_featured != null ? 1 : 0;
        $job->country_id = $request->country;
        $job->state_id = $request->state;
        $job->city_id = $request->city_id;
        $job->country_salary = $request->country_salary;
        $job->nepali_salary = $request->nepali_salary;
        $job->no_of_male = $request->male_employee;
        $job->no_of_female = $request->female_employee;
        $job->any_gender = $request->any_employee;
        $job->working_hours = $request->working_hours;
        $job->working_days = $request->working_days;
        $job->contract_year = $request->contract_year;
        $job->contract_month = $request->contract_month;
        $job->contract_description = $request->contract_description;
        $job->min_experience = $request->min_experience;
        $job->max_experience = $request->max_experience;
        $job->min_age = $request->min_age;
        $job->max_age = $request->max_age;
        if (!empty($request->skills)) {
            foreach ($request->skills as $key => $skill) {
                $skillData[] = $skill;
            }
            $job->skills = json_encode($skillData);
        }
        $job->requirement_intro = $request->requirement_intro;
        $job->requirements = $request->other_requirements;
        $job->benefit_intro = $request->benefit_intro;
        $job->accomodation = $request->accomodation;
        $job->food = $request->food;
        $job->annual_vacation = $request->annual_vacation;
        $job->over_time = $request->over_time;
        $job->earning_country_salary = $request->earning_country_salary;
        $job->earning_nepali_salary = $request->earning_nepali_salary;
        $job->pictures = '';
        if ($request->hasFile('picture')) {
            if(!file_exists($this->picturedestination)){
                mkdir($this->picturedestination, 077, true);
            }
            foreach ($request->file('picture') as $file) {
                $photoName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path($this->picturedestination, 'public'), $photoName);
                $photoData[] = $this->picturedestination . $photoName;
            }
            $job->pictures = json_encode($photoData);
        } else {
            $job->pictures = $oldpicture;
        }
    }
}
