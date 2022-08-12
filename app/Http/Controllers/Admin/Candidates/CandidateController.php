<?php

namespace App\Http\Controllers\Admin\Candidates;

use App\Http\Controllers\Controller;
use App\Models\Employe;
use App\Models\Industry;
use App\Models\Training;
use App\Models\User;
use App\Traits\Admin\AdminMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CandidateController extends Controller
{
    use AdminMethods;
    private $redirectTo = 'admin.candidates.list';
    public function __construct()
    {
        $this->experiencelevels = DB::table('experiencelevels')->get();
        $this->educationlevels = DB::table('educationlevels')->get();
        $this->job_shifts = DB::table('job_shifts')->get();
        $this->job_categories = DB::table('job_categories')->get();
        $this->countries = DB::table('countries')->where('is_active', 1)->get();
        $this->trainings = Training::get();
        $this->skills = DB::table('skills')->get();
        $this->states = DB::table('states')->get();
        $this->languages = DB::table('languages')->get();
        $this->jobs = DB::table('jobs')->get();
        $this->industries = Industry::get();
    }
    function list() {
        return $this->view('admin.pages.candidates.list', [
            // 'candidates' => DB::table('employes')->paginate(10)
            'candidates' => Employe::paginate(10),
        ]);
    }
    function new () {
        return $this->view('admin.pages.candidates.editadd', [
            'action' => "New",
            'countries' => $this->countries,
        ]);
    }

    public function create()
    {
        $statlanguage = DB::table('languages')->whereIn('lang', ['English', 'Nepali'])->get();
        return $this->view('admin.pages.candidates.create', [
            'action' => "New",
            'countries' => $this->countries,
            'educationLevels' => $this->educationlevels,
            'states' => $this->states,
            'skills' => $this->skills,
            'trainings' => $this->trainings,
            'statlanguage' => $statlanguage,
            'languages' => $this->languages,
            'job_categories' => $this->job_categories,
            'jobs' => $this->jobs,
            'industries' => $this->industries,
        ]);
    }

    public function editCandidate($id)
    {
        $employ = Employe::where('id', $id)->with('user')->first();
        return $this->view('admin.pages.candidates.edit', [
            'action' => "Edit",
            'viewRoute' => route('admin.candidates.show', $employ->id),
            'employ' => $employ,
            'countries' => $this->countries,
            'educationLevels' => $this->educationlevels,
            'states' => $this->states,
            'skills' => $this->skills,
            'trainings' => $this->trainings,
            'languages' => $this->languages,
            'job_categories' => $this->job_categories,
            'jobs' => $this->jobs,
            'employ_experiences' => DB::table('employes_experience')->where("employ_id", $employ->id)->get(),
            'industries' => $this->industries,
        ]);
    }

    public function show($id)
    {
        $employ = Employe::where('id', $id)
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
            ])->first();
        return $this->view('admin.pages.candidates.show', [
            'action' => "View",
            'employ' => $employ,
            'editRoute' => route('admin.candidates.editCandidate', $employ->id),
        ]);
    }

    public function store(Request $request)
    {

        // dd(!empty($request->skill));
        $validator = Validator::make($request->all(), [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'english_dob' => ['required'],
            'gender' => ['required'],
            'marital_status' => ['required'],
            'education_level_id' => ['required'],
            'mobile_number1' => ['required'],
            'email' => ['required', 'unique:users,email'],
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:12096'],
            'full_picture' => ['nullable'],
            'full_picture.*' => ['image', 'mimes:jpeg,png,jpg', 'max:12096'],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $user = new User();
                $user->email = $request->email;
                $user->password = Hash::make('12345678');
                $user->user_type = 'candidate';
                $user->email_verified_at = date('Y-m-d h:i:s');
                $user->created_at = date('Y-m-d h:i:s');
                $user->updated_at = date('Y-m-d h:i:s');
                $user->save();
                $this->__saveEmployee($user->id, $request);
                DB::commit();
                return response()->json(['msg' => 'Candidate created successfully', 'redirectRoute' => route($this->redirectTo)]);
            } catch (\Exception$e) {
                DB::rollBack();
                return response()->json(['db_error' => $e->getMessage()]);
                // return redirect()->back()->with(notifyMsg('warning', $e->getMessage()));
            }
        }
    }

    private $destination = 'uploads/candidates/profiles/';
    private $fullPictureDestination = 'uploads/candidates/full_picture/';

    public function update(Request $request, $id)
    {
        $employe = Employe::where('id', $id)->first();
        $validator = Validator::make($request->all(), [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'english_dob' => ['required'],
            'gender' => ['required'],
            'marital_status' => ['required'],
            'education_level_id' => ['required'],
            'mobile_number1' => ['required'],
            'email' => ['required', 'unique:users,email,' . $employe->user_id],
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:12096'],
            'full_picture' => ['nullable'],
            'full_picture.*' => ['image', 'mimes:jpeg,png,jpg', 'max:12096'],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $user = User::find($employe->user_id);
                $user->email = $request->email;
                $user->update([
                    'email' => $request->email,
                    'user_type' => 'candidate',
                ]);
                $this->__updateEmployee($id, $user->id, $request);
                DB::commit();
                return response()->json(['msg' => 'Candidate updated successfully', 'redirectRoute' => route($this->redirectTo)]);
            } catch (\Exception$e) {
                DB::rollBack();
                return response()->json(['db_error' => $e->getMessage()]);
                // return redirect()->back();
            }
        }
    }

    private function __updateEmployee($employe_id, $user_id, $request)
    {
        $employe = Employe::find($employe_id);
        $employe->first_name = $request->first_name;
        $employe->middle_name = $request->middle_name;
        $employe->last_name = $request->last_name;
        $employe->dob = $request->english_dob;
        $employe->gender = $request->gender;
        $employe->marital_status = $request->marital_status;
        $employe->state_id = $request->state_id;
        $employe->mobile_phone = $request->mobile_number1;
        $employe->user_id = $user_id;
        $employe->address = $request->address_line;
        $employe->city_street = $request->city_street;
        $employe->height = $request->height;
        $employe->weight = $request->weight;
        $employe->is_active = '1';
        $employe->is_verified = '1';
        if ($request->hasFile('profile_picture')) {
            $prf = $request->file('profile_picture');
            $prfName = time() . '_' . $prf->getClientOriginalName();
            $employe->avatar = $this->destination . $prfName;
            $prf->move(public_path($this->destination, 'public'), $prfName);
        }

        if ($request->hasFile('full_picture')) {
            foreach ($request->file('full_picture') as $file) {
                $photoName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path($this->fullPictureDestination, 'public'), $photoName);
                $photoData[] = $this->fullPictureDestination . $photoName;
            }
            $employe->full_picture = json_encode($photoData);
        }

        $employe->education_level_id = $request->education_level_id;
        $employe->dob_in_bs = $request->nepali_dob;
        $employe->mobile_phone2 = $request->mobile_number2;
        $employe->district_id = $request->district_id;
        $employe->municipality = $request->municipality;
        $employe->ward = $request->ward;
        $employe->passport_number = $request->passport_number;
        $employe->passport_expiry_date = $request->passport_expiry_date;
        $employe->is_experience = $request->is_experience !== null && $request->is_experience == 'Yes' ? 1 : 0;
        if (!empty($request->training)) {
            foreach ($request->training as $key => $training) {
                $trainingData[] = $training;
            }
            $employe->trainings = json_encode($trainingData);
        }
        if (!empty($request->skill)) {
            foreach ($request->skill as $key => $skill) {
                $skillData[] = $skill;
            }
            $employe->skills = json_encode($skillData);
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
                $employe->languages = json_encode($languageData);
            }

        }

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
                $employe->experiences = json_encode($experienceData);
            }

        }
        $employe->save();

        $this->__updateExperience($employe->id, $request);
        $this->__updateEmployeSkill($employe->id, $request);
        $this->__updateEmployeLanguage($employe->id, $request);
        $this->__updateEmployeTraining($employe->id, $request);
    }

    public function __updateExperience($employ_id, $request)
    {
        DB::table('employes_experience')->where('employ_id', $employ_id)->delete();

        $fields = [];
        if ($request->is_experience != null && $request->is_experience == 'Yes' && !empty($request->country_id)) {
            foreach ($request->country_id as $key => $country) {
                if ($country != null) {
                    $fields['employ_id'] = $employ_id;
                    $fields['country_id'] = $country;
                    $fields['job_category_id'] = isset($request->get('job_category_id')[$key]) ? $request->get('job_category_id')[$key] : '';
                    $fields['industry_id'] = isset($request->get('industry_id')[$key]) ? $request->get('industry_id')[$key] : '';
                    $fields['working_year'] = isset($request->get('working_year')[$key]) ? $request->get('working_year')[$key] : '';
                    $fields['working_month'] = isset($request->get('working_month')[$key]) ? $request->get('working_month')[$key] : '';
                    DB::table('employes_experience')->insert($fields);
                }

            }

        }
    }

    private function __updateEmployeSkill($employ_id, $request)
    {
        if (!empty($request->skill || $request->skill != null)) {
            DB::table('employes_skills')->where('employ_id', $employ_id)->delete();
            $fields = [];
            foreach ($request->skill as $key => $skill) {
                $fields['employ_id'] = $employ_id;
                $fields['skills_id'] = $skill;
                DB::table('employes_skills')->insert($fields);
            }
        }
    }

    private function __updateEmployeTraining($employ_id, $request)
    {
        if (!empty($request->training || $request->training != null)) {
            DB::table('employee_trainings')->where('employee_id', $employ_id)->delete();
            $fields = [];
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
        foreach ($request->language as $key => $language) {
            if ($language != null) {
                $fields['employ_id'] = $employ_id;
                $fields['language_id'] = $language;
                $fields['language_level'] = isset($request->get('language_level')[$key]) ? $request->get('language_level')[$key] : '';
                // $fields['language_level'] = $request->get('language_level_'.$language)[0];
                DB::table('employes_languages')->insert($fields);
            }

        }

    }

    private function __saveEmployee($user_id, $request)
    {

        $employe = new Employe();
        $employe->first_name = $request->first_name;
        $employe->middle_name = $request->middle_name;
        $employe->last_name = $request->last_name;
        $employe->dob = $request->english_dob;
        $employe->gender = $request->gender;
        $employe->marital_status = $request->marital_status;
        $employe->state_id = $request->state_id;
        $employe->mobile_phone = $request->mobile_number1;
        $employe->user_id = $user_id;
        $employe->address = $request->address_line;
        $employe->city_street = $request->city_street;
        $employe->height = $request->height;
        $employe->weight = $request->weight;
        $employe->is_active = '1';
        $employe->is_verified = '1';
        if ($request->hasFile('profile_picture')) {
            $prf = $request->file('profile_picture');
            $prfName = time() . '_' . $prf->getClientOriginalName();
            $employe->avatar = $this->destination . $prfName;
            $prf->move(public_path($this->destination, 'public'), $prfName);
        }

        if ($request->hasFile('full_picture')) {
            foreach ($request->file('full_picture') as $file) {
                $photoName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path($this->fullPictureDestination, 'public'), $photoName);
                $photoData[] = $this->fullPictureDestination . $photoName;
            }
            $employe->full_picture = json_encode($photoData);
        }

        $employe->education_level_id = $request->education_level_id;
        $employe->dob_in_bs = $request->nepali_dob;
        $employe->mobile_phone2 = $request->mobile_number2;
        $employe->district_id = $request->district_id;
        $employe->municipality = $request->municipality;
        $employe->ward = $request->ward;
        $employe->passport_number = $request->passport_number;
        $employe->passport_expiry_date = $request->passport_expiry_date;
        $employe->is_experience = $request->is_experience !== null && $request->is_experience == 'Yes' ? 1 : 0;
        if (!empty($request->training)) {
            foreach ($request->training as $key => $training) {
                $trainingData[] = $training;
            }
            $employe->trainings = json_encode($trainingData);
        }
        if (!empty($request->skill)) {
            foreach ($request->skill as $key => $skill) {
                $skillData[] = $skill;
            }
            $employe->skills = json_encode($skillData);
        }

        if (!empty($request->language)) {
            $languageData = [];
            foreach ($request->language as $key => $language) {
                // $languageData[] = $language;
                // $languageData[] = $request->get('language_level')[$key];
                // $languageData[$language] = $request->get('language_level')[$key];
                if ($language != null) {
                    $languageData[] = [
                        'language_id' => $language,
                        'language_level' => isset($request->get('language_level')[$key]) ? $request->get('language_level')[$key] : '',
                    ];
                }

            }
            if (!empty($languageData)) {
                $employe->languages = json_encode($languageData);
            }

        }

        if ($request->is_experience != null && $request->is_experience && !empty($request->country_id)) {
            $experienceData = [];
            foreach ($request->country_id as $key => $country) {
                if ($country != null) {
                    $experienceData[] =
                        [
                        'country_id' => $country,
                        'job_category_id' => isset($request->get('job_category_id')[$key]) ? $request->get('job_category_id')[$key] : '',
                        'industry_id' => isset($request->get('industry_id')[$key]) ? $request->get('industry_id')[$key] : '',
                        'working_year' => isset($request->get('working_year')[$key]) ? $request->get('working_year')[$key] : '',
                        'working_month' => isset($request->get('working_month')[$key]) ? $request->get('working_month')[$key] : '',
                    ];
                }

            }
            if (!empty($experienceData)) {
                $employe->experiences = json_encode($experienceData);
            }

        }
        $employe->save();

        $this->__saveExperience($employe->id, $request);
        $this->__saveEmployeSkill($employe->id, $request);
        $this->__saveEmployeLanguage($employe->id, $request);
        $this->__saveEmployeeTraining($employe->id, $request);
    }

    private function __saveEmployeSkill($employ_id, $request)
    {
        $fields = [];
        if (!empty($request->skill || $request->skill != null)) {
            foreach ($request->skill as $key => $skill) {
                $fields['employ_id'] = $employ_id;
                $fields['skills_id'] = $skill;
                DB::table('employes_skills')->insert($fields);
            }
        }

    }

    private function __saveEmployeeTraining($employ_id, $request)
    {
        $fields = [];
        if (!empty($request->training || $request->training != null)) {
            foreach ($request->training as $key => $training) {
                $fields['employee_id'] = $employ_id;
                $fields['training_id'] = $training;
                DB::table('employee_trainings')->insert($fields);
            }
        }
    }

    private function __saveEmployeLanguage($employ_id, $request)
    {
        $fields = [];
        foreach ($request->language as $key => $language) {
            if ($language != null) {
                $fields['employ_id'] = $employ_id;
                $fields['language_id'] = $language;
                $fields['language_level'] = isset($request->get('language_level')[$key]) ? $request->get('language_level')[$key] : '';
                DB::table('employes_languages')->insert($fields);
            }

        }

    }

    private function __saveExperience($employe_id, $request)
    {
        $fields = [];
        if ($request->is_experience != null && $request->is_experience == 'Yes' && !empty($request->country_id)) {
            foreach ($request->country_id as $key => $country) {
                if ($country != null) {
                    $fields['employ_id'] = $employe_id;
                    $fields['country_id'] = $country;
                    $fields['job_category_id'] = isset($request->get('job_category_id')[$key]) ? $request->get('job_category_id')[$key] : '';
                    $fields['industry_id'] = isset($request->get('industry_id')[$key]) ? $request->get('industry_id')[$key] : '';
                    $fields['working_year'] = isset($request->get('working_year')[$key]) ? $request->get('working_year')[$key] : '';
                    $fields['working_month'] = isset($request->get('working_month')[$key]) ? $request->get('working_month')[$key] : '';
                    DB::table('employes_experience')->insert($fields);
                }
            }

        }
    }

    public function edit($id)
    {
        $candidate = Employe::find($id);
        // dd(User::find($candidate->user_id));
        return $this->view('admin.pages.candidates.editadd', [
            'candidate' => $candidate,
            'action' => "Edit",
            'candidate_user' => User::find($candidate->user_id),
            'countries' => $this->countries,
        ]);
    }

    public function save(Request $request)
    {
        // dd($request);
        $userfield = [];
        $request->password ? $userfield['password'] = bcrypt($request->password) : null;
        $userfield['email'] = $request->email;
        $user = User::updateOrCreate(['id' => $request->user_id], $userfield);

        $request->avatar ? $avatarfile = time() . '_' . $request->avatar->getClientOriginalName() : null;
        $request->avatar ? $request->avatar->move(public_path('uploads/candidates/profiles', 'public'), $avatarfile) : null;

        $fields = [];
        $request->first_name ? $fields['first_name'] = $request->first_name : null;
        $request->middle_name ? $fields['middle_name'] = $request->middle_name : null;
        $request->last_name ? $fields['last_name'] = $request->last_name : null;
        $request->mobile_phone ? $fields['mobile_phone'] = $request->mobile_phone : null;
        $request->avatar ? $fields['avatar'] = 'uploads/candidates/profiles/' . $avatarfile : null;
        $request->dob ? $fields['dob'] = $request->dob : null;
        $fields['user_id'] = $user->id;
        $request->gender ? $fields['gender'] = $request->gender : null;
        $request->marital_status ? $fields['marital_status'] = $request->marital_status : null;
        $request->nationality ? $fields['nationality'] = $request->nationality : null;

        $request->country_id ? $fields['country_id'] = $request->country_id : null;
        $request->state_id ? $fields['state_id'] = $request->state_id : null;
        $request->city_id ? $fields['city_id'] = $request->city_id : null;

        $request->address ? $fields['address'] = $request->address : null;
        $request->is_active ? $fields['is_active'] = $request->is_active == "on" ? 1 : 0 : null;

        $candidate = Employe::updateOrCreate(['id' => $request->id], $fields);

        return $this->view('admin.pages.candidates.editadd', [
            'candidate' => $candidate,
            'action' => "Edit",
            'candidate_user' => User::find($candidate->user_id),
            'countries' => $this->countries,
        ]);
    }
    public function delete($id)
    {
        try{
            DB::beginTransaction();
            $employe = Employe::find($id);
            if(!blank($employe) && (blank($employe->job_applications) AND blank($employe->experience) AND blank($employe->employeeSkills) AND blank($employe->employeeTrainings) AND blank($employe->employeeLanguage) AND blank($employe->countryPreference) AND blank($employe->jobCategoryPreference) AND blank($employe->industryPreference))){
                $employe->followings()->delete();
                $employe->delete();
            } else {
                return redirect()->back()->with(notifyMsg('error', 'Failed To Delete Candidate'));
            }
            
            DB::commit();
            return redirect()->back()->with(notifyMsg('success', 'Candidate deleted successfully'));
        } catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with(notifyMsg('error', $e->getMessage()));
        }
    }
}
