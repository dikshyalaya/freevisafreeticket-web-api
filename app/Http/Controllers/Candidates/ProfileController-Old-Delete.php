<?php

namespace App\Http\Controllers\Candidates;

use App\Models\Country;
use PDF;
use App\Http\Controllers\Controller;
use App\Models\EducationLevel;
use App\Models\Employe;
use App\Models\EmployeeSkill;
use App\Models\EmployeeTraining;
use App\Models\EmployJobPreference;
use App\Models\ExperienceLevel;
use App\Models\Industry;
use App\Models\Job;
use App\Models\JobShift;
use App\Models\Language;
use App\Models\Skill;
use App\Models\State;
use App\Models\Training;
use App\Traits\Site\CandidateMethods;
use App\Traits\Site\ThemeMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProfileControllerOldDelete extends Controller
{
    use ThemeMethods;
    use CandidateMethods;

    public function __construct()
    {
        $this->middleware('auth');
        $this->experiencelevels = ExperienceLevel::get();
        $this->educationlevels = EducationLevel::get();
        $this->job_shifts = JobShift::get();
        // $this->job_categories = \DB::table('job_categories')->get();
        // $this->countries = \DB::table('countries')->get();
        $this->trainings = Training::get();
        $this->skills = Skill::get();
        $this->states = State::get();
        $this->languages = Language::get();
        $this->jobs = Job::get();
        $this->industries = Industry::get();
    }

    public function profile()
    {
        $employ = Employe::where('user_id', Auth::user()->id)
            ->with([
                'user:id,email',
                'country:id,name',
                'state:id,name',
                'city:id,name',
                'education_level:id,title',
                'employeeSkills.skill:id,title',
                'employeeLanguage.language:id,lang',
                'experience.country:id,name',
                'experience.job_category:id,functional_area',
                'experience.industry:id,title',
                // 'experience.job:id,title'
            ])->first();
        return $this->client_view('candidates.profile.index', [
            'employ' => $employ,
        ]);
    }
    private $destination = 'uploads/candidates/profiles/';
    private $fullPictureDestination = 'uploads/candidates/full_picture/';
    private $redirectTo = "candidate.profile";

    public function get_personal_information()
    {
        $employ = Employe::where('user_id', auth()->user()->id)->first();
        return $this->client_view('candidates.profile.get_personal_information', [
            'employ' => $employ,
        ]);
    }

    public function post_personal_information(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'english_dob' => ['required'],
            'nepali_dob' => ['required'],
            'gender' => ['required'],
            'marital_status' => ['required'],
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ], [
            'first_name.required' => 'The first name field is required',
            'last_name.required' => 'The last name field is required',
            'english_dob.required' => 'Date of birth field is required',
            'nepali_dob.required' => 'Date of birth field is required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $employ = Employe::where('user_id', $request->user_id)->first();
                if ($request->hasFile('profile_picture')) {
                    $prf = $request->file('profile_picture');
                    $prfName = time() . '_' . $prf->getClientOriginalName();
                    $avatar = $this->destination . $prfName;
                    $prf->move(public_path($this->destination, 'public'), $prfName);
                } else {
                    $avatar = $employ->avatar;
                }
                $employ->update([
                    'first_name' => $request->first_name,
                    'middle_name' => $request->middle_name,
                    'last_name' => $request->last_name,
                    'dob_in_bs' => $request->nepali_dob,
                    'dob' => $request->english_dob,
                    'gender' => $request->gender,
                    'marital_status' => $request->marital_status,
                    'user_id' => $request->user_id,
                    'height' => $request->height,
                    'weight' => $request->weight,
                    'is_active' => 1,
                    'is_verified' => 1,
                    'avatar' => $avatar,
                    'passport_number' => $request->passport_number,
                    'passport_expiry_date' => $request->passport_expiry_date,
                ]);
                DB::commit();
                $redirectTo = route('candidate.profile.get_contact_information');
                return response()->json(['redirectRoute' => $redirectTo]);
            } catch (\Exception$e) {
                DB::rollBack();
                return response()->json(['db_error' => $e->getMessage()]);
            }

        }
    }

    public function get_contact_information(Request $request)
    {
        $employ = $this->employe();
        return $this->client_view('candidates.profile.get_contact_information', [
            'employ' => $employ,
            'states' => $this->states,
        ]);
    }

    public function post_contact_information(Request $request)
    {
        $employe = Employe::where('user_id', $request->user_id)->first();
        $validator = Validator::make($request->all(), [
            'mobile_number1' => ['required'],
            'email' => ['required', 'unique:users,email,' . $employe->user_id],
            'country_id' => ['required'],
            'state_id' => ['required'],
//            'district_id' => ['required'],
        ], [
            'mobile_number1.required' => 'The mobile number field is required',
            'country_id.required' => 'Country is required',
            'state_id.required' => 'State is required',
            'district_id.required' => 'District is required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $employe->update([
                    'country_id' => $request->country_id,
                    'state_id' => $request->state_id,
                    'district_id' => $request->district_id,
                    'mobile_phone' => $request->mobile_number1,
                    'mobile_phone2' => $request->mobile_number2,
                    'address' => $request->address_line,
                    'city_street' => $request->city_street,
                    'municipality' => $request->municipality,
                    'ward' => $request->ward,
                ]);

                DB::commit();
                $redirectTo = route('candidate.profile.get_qualification');
                return response()->json(['redirectRoute' => $redirectTo]);
            } catch (\Exception$e) {
                DB::rollBack();
                return response()->json(['db_error' => $e->getMessage()]);
            }
        }
    }

    public function get_qualification()
    {
        $employ = $this->employe();
        return $this->client_view('candidates.profile.get_qualification', [
            'employ' => $employ,
            'educationLevels' => $this->educationlevels,
            'trainings' => $this->trainings,
            'skills' => $this->skills,
            'languages' => $this->languages,
        ]);
    }

    public function post_qualification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'education_level_id' => ['required'],
        ], [
            'education_level_id.required' => 'The education level field is required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $employe = Employe::where('user_id', $request->user_id)->first();
                $fields = [];
                if (!empty($request->training)) {
                    foreach ($request->training as $key => $training) {
                        $trainingData[] = $training;
                    }
                    $fields['trainings'] = json_encode($trainingData);
                }
                if (!empty($request->skill)) {
                    foreach ($request->skill as $key => $skill) {
                        $skillData[] = $skill;
                    }
                    $fields['skills'] = json_encode($skillData);
                }
                if (!empty($request->language)) {
                    $languageData = [];
                    foreach ($request->language as $key => $language) {
                        if ($language != null) {
                            $languageData[] = [
                                'language_id' => $language,
                                'language_level' => $request->get('language_level')[$key],
                            ];
                        }

                    }
                    if (!empty($languageData)) {
                        $fields['languages'] = json_encode($languageData);
                    }

                }
                $fields['education_level_id'] = $request->education_level_id;
                $employe->update($fields);
                $this->__updateEmployeeSkill($employe->id, $request);
                $this->__updateEmployeLanguage($employe->id, $request);
                $this->__updateEmployeeTraining($employe->id, $request);
                DB::commit();
                $redirectTo = route('candidate.profile.get_experience');
                return response()->json(['redirectRoute' => $redirectTo]);
            } catch (\Exception$e) {
                DB::rollBack();
                return response()->json(['db_error' => $e->getMessage()]);}
        }
    }

    public function get_experience()
    {
        $employ = $this->employe();
        return $this->client_view('candidates.profile.get_experience', [
            'employ' => $employ,
            'jobs' => $this->jobs,
            'languages' => $this->languages,
            'industries' => $this->industries,
        ]);
    }

    public function post_experience(Request $request)
    {
        try {
            DB::beginTransaction();
            $employe = Employe::where('user_id', $request->user_id)->first();
            $fields = [];
            $fields['is_experience'] = $request->is_experience !== null && $request->is_experience == 'Yes' ? 1 : 0;
            if ($request->is_experience != null && $request->is_experience == 'Yes' && !empty($request->country_id)) {
                $experienceData = [];
                foreach ($request->country_id as $key => $country) {
                    if ($country != null) {
                        $experienceData[] =
                            [
                            'country_id' => $country,
                            'job_category_id' => $request->get('job_category_id')[$key],
                            'industry_id' => $request->get('industry_id')[$key],
                            'working_year' => $request->get('working_year')[$key],
                            'working_month' => $request->get('working_month')[$key],
                        ];
                    }

                }
                if (!empty($experienceData)) {
                    $fields['experiences'] = json_encode($experienceData);
                    // $employe->experiences = json_encode($experienceData);
                }

            }
            $employe->update($fields);
            $this->__updateExperience($employe->id, $request);
            DB::commit();
            $redirectTo = route('candidate.profile.get_preferred_jobs');
            // $redirectTo = route('candidate.profile.get_preview');
            return response()->json(['redirectRoute' => $redirectTo]);
        } catch (\Exception$e) {
            DB::rollBack();
            return response()->json(['db_error' => $e->getMessage()]);
        }
    }

    public function get_preferred_jobs()
    {
        $employ = $this->employe();
        return $this->client_view('candidates.profile.get_preferred_jobs', [
            'employ' => $employ,
        ]);
    }

    public function post_preferred_jobs(Request $request)
    {
        try {
            DB::beginTransaction();
            if (in_array(!null, $request->categories) || in_array(!null, $request->countries) || in_array(!null, $request->job_title)) {
                $preferences = EmployJobPreference::where('employ_id', $this->employe()->id);
                if ($preferences->exists()) {
                    $preferences->delete();
                }

                $this->employe()->update([
                    'job_notify' => $request->has('job_notify') ? 1 : 0,
                ]);

                foreach ($request->categories as $key => $category) {
                    if ($category != null) {
                        EmployJobPreference::create([
                            'employ_id' => $this->employe()->id,
                            'job_category_id' => $category,
                        ]);
                    }
                }
                foreach ($request->countries as $key => $country) {
                    if ($country != null) {
                        EmployJobPreference::create([
                            'country_id' => $country,
                            'employ_id' => $this->employe()->id,
                        ]);
                    }
                }
                foreach ($request->job_title as $key => $job_title) {
                    if ($job_title != null) {
                        EmployJobPreference::create([
                            'job_title' => $job_title,
                            'employ_id' => $this->employe()->id,
                        ]);
                    }
                }
            }

            DB::commit();
            return response()->json(['msg' => 'Job Preference updated successfully', 'redirectRoute' => route('candidate.profile.get_preview')]);
        } catch (\Exception$e) {
            DB::rollBack();
            return response()->json(['db_error' => $e->getMessage()]);
        }
    }

    public function get_preview()
    {
        $employ = Employe::where('user_id', Auth::user()->id)
        ->with([
            'user:id,email',
            'country:id,name', 
            'state:id,name', 
            'city:id,name', 
            'education_level:id,title', 
            'employeeSkills.skill:id,title', 
            'employeeLanguage.language:id,lang', 
            'experience.country:id,name', 
            'experience.job_category:id,functional_area', 
            // 'experience.industry:id,title',
            // 'experience.job:id,title'
            ])->first();
        return $this->client_view('candidates.profile.get_preview', [
            'employ' => $employ,
        ]);
    }

    public function get_save()
    {
        $employ = $this->employe();
        return $this->client_view('candidates.profile.get_save', [
            'employ' => $employ,
        ]);
    }

    private function __updateEmployeeSkill($employ_id, $request)
    {
        EmployeeSkill::where('employ_id', $employ_id)->delete();
        $fields = [];
        if (isset($request->skill) and !blank($request->skill)) {
            foreach ($request->skill as $key => $skill) {
                $fields['employ_id'] = $employ_id;
                $fields['skills_id'] = $skill;
                DB::table('employes_skills')->insert($fields);
            }
        }
    }

    private function __updateEmployeeTraining($employ_id, $request)
    {
        EmployeeTraining::where('employee_id', $employ_id)->delete();
        $fields = [];
        if (isset($request->training) and !blank($request->training)) {
            foreach ($request->training as $key => $training) {
                $fields['employee_id'] = $employ_id;
                $fields['training_id'] = $training;
                DB::table('employee_trainings')->insert($fields);
            }
        }
    }

    private function __updateEmployeLanguage($employ_id, $request)
    {
        DB::table('employes_languages')->where('employ_id', $employ_id)->delete();
        $fields = [];
        if (isset($request->language) and !blank($request->language)) {
            foreach ($request->language as $key => $language) {
                if (!blank($language)) {
                    $fields['employ_id'] = $employ_id;
                    $fields['language_id'] = $language;
                    $fields['language_level'] = $request->get('language_level')[$key];
                    DB::table('employes_languages')->insert($fields);
                }
            }
        }
    }

    private function __updateExperience($employ_id, $request)
    {
        DB::table('employes_experience')->where('employ_id', $employ_id)->delete();

        $fields = [];
        if ($request->is_experience != null && $request->is_experience == 'Yes' && !empty($request->country_id)) {
            foreach ($request->country_id as $key => $country) {
                if ($country != null) {
                    $fields['employ_id'] = $employ_id;
                    $fields['country_id'] = $country;
                    $fields['job_category_id'] = $request->get('job_category_id')[$key];
                    $fields['industry_id'] = $request->get('industry_id')[$key];
                    $fields['working_year'] = $request->get('working_year')[$key];
                    $fields['working_month'] = $request->geT('working_month')[$key];
                    DB::table('employes_experience')->insert($fields);
                }

            }

        }
    }

    public function get_cv(Request $request)
    {
        $employ = $this->employe();
        return $this->client_view('candidates.profile.get_cv', [
            'employ' => $employ,
        ]);
    }

    public function downloadGeneratedCV(Request $request)
    {
        $q = Job::query();
        $category_id = [];
        $job_title = [];
        $country_id = [];
        $preference = EmployJobPreference::where('employ_id', $this->employe()->id)->get();
        $category_id = array_merge(
            $category_id,
            $preference
                ->whereNotNull('job_category_id')
                ->pluck('job_category_id')
                ->toArray(),
        );
        $job_title = array_merge(
            $job_title,
            $preference
                ->whereNotNull('job_title')
                ->pluck('job_title')
                ->toArray(),
        );
        $country_id = array_merge(
            $country_id,
            $preference
                ->whereNotNull('country_id')
                ->pluck('country_id')
                ->toArray(),
        );
        $q->whereIn('job_categories_id', $category_id)
            ->orWhereIn('country_id', $country_id)
            ->when($job_title, function ($q3) use ($job_title) {
                foreach ($job_title as $title) {
                    $q3->orWhere('title', 'LIKE', '%' . $title . '%');
                }
            });
        $jobs = $q->take(5)->get('title');
        $employ = $this->employe([
            'user:id,email',
            'country:id,name',
            'state:id,name',
            'city:id,name',
            'education_level:id,title',
            'employeeSkills.skill:id,title',
            'employeeLanguage.language:id,lang',
            'experience.country:id,name',
            'experience.job_category:id,functional_area',
            // 'experience.job:id,title',
            'experience.industry:id,title',
        ]);
        // return $this->client_view('candidates.profile.cv', [
        //     //'employ' => $this->employe(['user:id,email', 'country:id,name', 'state:id,name', 'city:id,name', 'education_level:id,title', 'employeeSkills.skill:id,title', 'employeeLanguage.language:id,lang', 'experience.country:id,name', 'experience.job_category:id,functional_area', 'experience.job:id,title']),
        //     'employ' => $employ,
        //     'jobs' => $jobs,
        // ]);
        $pdf = PDF::loadView('themes.fvft.candidates.profile.cv', compact('employ', 'jobs'))->setPaper('a4', 'portrait');
        PDF::setOptions(['dpi' => 300]);
        if ($request->type == 'preview') {
            return $pdf->stream($employ->full_name . '.pdf');
        }
        return $pdf->download($employ->full_name . '.pdf');

    }
}
