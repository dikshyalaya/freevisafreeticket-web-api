<?php

namespace App\Http\Controllers\API\Candidates;

use App\Http\Controllers\Controller;
use App\Models\EmployeeEducation;
use App\Models\EmployeeExperience;
use App\Models\EmployeeLanguage;
use App\Models\EmployeeSkill;
use App\Models\EmployeeTraining;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employe;
use Illuminate\Support\Facades\Auth;
use App\Traits\Api\ApiMethods;
use DB;

class ProfileController extends Controller
{
    use ApiMethods;

    public function get_profile()
    {
        $user  = Auth::user();
        $employee = Employe::with([
            'country',
            'state',
            'district',
            'city',
            'experience',
            'experience.country',
            'experience.job_category',
            'experience.industry',
            'education',
            'education.educationLevel',
            'employeeSkills',
            'employeeSkills.skill',
            'employeeLanguage',
            'employeeLanguage.language',
            'preferredCountry',
            'preferredCountry.country',
            'cv',
            'job_applications',
            'job_preference',
            'trainings.training'
        ])
            ->where('user_id', $user->id)->first();
        $responseData = $this->sendResponse(compact('employee', 'user'), 'success', '');
        return $responseData;
    }

    private $destination = 'uploads/candidates/profiles/';
    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $employee = Employe::where('user_id', $user->id)->firstOrFail();

        if (!$request->page OR blank($request->page)){
            return $this->sendResponse([], 'page value mismatch', '', false);
        }

        if ($request->page == 'personal_information') {
            if ($request->hasFile('profile_picture')) {
                $prf = $request->file('profile_picture');
                $prfName = time() . '_' . $prf->getClientOriginalName();
                $avatar = $this->destination . $prfName;
                $prf->move(public_path($this->destination, 'public'), $prfName);
            } else {
                $avatar = $employee->avatar;
            }

            $employee->update([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'dob' => $request->english_dob,
                'gender' => $request->gender,
                'marital_status' => $request->marital_status,
                'height' => $request->height,
                'weight' => $request->weight,
                'avatar' => $avatar,
                'passport_number' => $request->passport_number,
                'passport_expiry_date' => $request->passport_expiry_date,
            ]);
        }
        elseif($request->page == 'contact_information'){
            $employee->mobile_phone = $request->phone1;
            $employee->mobile_phone2 = $request->phone2;
            $employee->country_id = $request->country_id;
            $employee->state_id = $request->state_id;
            $employee->district_id = $request->district_id;
            $employee->municipality = $request->municipality;
            $employee->city_id = $request->city_id;
            $employee->ward = $request->ward;
            $employee->address = $request->address;
            $employee->save();
        }
        elseif($request->page == 'qualification'){

            if (isset($request->education_id) AND !blank($request->education_id)){
                $education_level = json_decode($request->education_id);
                if (!is_array($education_level)){
                    return $this->sendResponse('', 'education id must be an array', '', false);
                }
                // remove education level
                EmployeeEducation::where('employ_id', $employee->id)->delete();
                foreach ($education_level as $value){
                    $employee_education = new EmployeeEducation();
                    $employee_education->employ_id = $employee->id;
                    $employee_education->educationlevels_id = $value;
                    $employee_education->save();
                }
            }

            if (isset($request->training) AND !blank($request->training)){
                $trainings = json_decode($request->training);

                if (!is_array($trainings)){
                    return $this->sendResponse('', 'training id must be an array', '', false);
                }

                EmployeeTraining::where('employee_id', $employee->id)->delete();
                foreach ($trainings as $training) {
                    $employee_training = new EmployeeTraining();
                    $employee_training->employee_id = $employee->id;
                    $employee_training->training_id = $training;
                    $employee_training->save();
                }
//                $fields['trainings'] = json_encode($trainings);
//                $employee->update($fields);
            }

            if (isset($request->skill) AND !blank($request->skill)){
                EmployeeSkill::where('employ_id', $employee->id)->delete();
                $skills = json_decode($request->skill);

                if (!is_array($skills)){
                    return $this->sendResponse('', 'skill id must be an array', '', false);
                }

                foreach ($skills as $skill) {
                    $employee_skill = new EmployeeSkill();
                    $employee_skill->employ_id = $employee->id;
                    $employee_skill->skills_id = $skill;
                    $employee_skill->save();
                }

            }

            if (isset($request->language) AND !blank($request->language)){
                EmployeeLanguage::where('employ_id', $employee->id)->delete();
                $languages = json_decode($request->language, true);

                if (!is_array($languages)){
                    return $this->sendResponse('', 'language id must be an array', '', false);
                }

                foreach ($languages as $language_id => $level) {
                    if (!blank($language_id)) {
                        $employee_language = new EmployeeLanguage();
                        $employee_language->employ_id = $employee->id;
                        $employee_language->language_id = $level['language_id'];
                        $employee_language->language_level = $level['level'];
                        $employee_language->save();
                    }
                }
            }
        }
        elseif ($request->page == 'experience'){

            EmployeeExperience::where('employ_id', $employee->id)->delete();
            $experiences = json_decode($request->experience, true);

            if (!is_array($experiences)){
                return $this->sendResponse('', 'experience id must be an array', '', false);
            }
            foreach($experiences as $experience) {
                $employee_experience = new EmployeeExperience();
                $employee_experience->employ_id = $employee->id;
                $employee_experience->experiencelevels_id = $experience['experiencelevels_id'];
                $employee_experience->country_id = $experience['country_id'];
//                $employee_experience->job_category_id = $experience['job_category_id'];
//                $employee_experience->job_title_id = $experience['job_title_id'];
                $employee_experience->job_category_id = $experience['job_category_id'];
                $employee_experience->industry_id = $experience['industry_id'];
                $employee_experience->working_year = $experience['working_year'];
                $employee_experience->working_month = $experience['working_month'];
                $employee_experience->save();
            }
        }

        $employee = Employe::with([
            'country',
            'state',
            'district',
            'city',
            'experience',
            'experience.country',
            'experience.job_category',
            'experience.industry',
            'education_level',
            'education.educationLevel',
            'employeeSkills',
            'employeeSkills.skill',
            'employeeLanguage',
            'employeeLanguage.language',
            'preferredCountry',
            'preferredCountry.country',
            'cv',
            'job_applications',
            'job_preference',
            'trainings.training'
        ])
            ->where('user_id', $user->id)->first();

        $responseData = $this->sendResponse(compact('employee', 'user'), 'success', '');
        return $responseData;
    }

    public function save_profile(Request $request)
    {
        try {
            $user = User::find(Auth::user()->id);

            $employe = Employe::where('user_id', $user->id)->first();

            if ($request->has('phone')) {
                $employe->update(["mobile_phone" => $request->phone]);
            }

            if ($request->has('first_name')) {
                $employe->update(["first_name" => $request->first_name]);
            }

            if ($request->has('middle_name')) {
                $employe->update(["middle_name" => $request->middle_name]);
            }

            if ($request->has('last_name')) {
                $employe->update(["last_name" => $request->last_name]);
            }

            if ($request->has('profile_img')) {
                $base64 = $request->profile_img["base64"];
                $image_info = getimagesize($base64);
                $extension = (isset($image_info["mime"]) ? explode('/', $image_info["mime"])[1] : "");
                $suported_type = array('png', 'jpg', 'jpeg');
                if (in_array($extension, $suported_type)) {
                    $upload = $this->upload($request->profile_img["base64"]);
                    $employe->update(["avatar" => $upload]);
                }
            }

            return $this->get_profile("Profile Updated Successfully.");
        }catch (\Exception $e){
            $responseData = $this->sendResponse([], $e->getMessage(), '', false);
            return $responseData;
        }

    }
    private function process($user){
        $employe= Employe::where('user_id',$user->id)->first();
        return [
            "user_id"=>$user->id,
            "first_name"=>$employe->first_name,
            "middle_name"=>$employe->middle_name,
            "last_name"=>$employe->last_name,
            "email"=>$user->email,
            "phone"=>$employe->mobile_phone,
            "user_type"=>$user->user_type,
            'is_verified'=>$employe->is_verified==1?true:false,
            'image_url'=>env("APP_URL").$employe->avatar,
        ];
    }

    public function change_password(Request $request){
        // return $request;
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required'
        ]);

        if(\Hash::check($request->old_password, auth()->user()->password)){
            $authuser=Auth::user();
            $user=User::find($authuser->id);
            $user->update([
                "password"=>bcrypt($request->new_password)
            ]);
            $employe= Employe::where('user_id',$user->id)->first();
            $token = $authuser->token();
            $token->revoke();
            $accesstoken = $authuser->createToken('FVFT_AcessToken')->accessToken;
            return $this->sendResponse([
                "token" => $accesstoken
            ],"Password Changed!");
        }else{
            return $this->sendError("Password Not Matched !");
        }
    }
    public function upload($img)
    {
        $folderPath = "uploads/candidates/profiles/";
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . sha1(time()).'.'.$image_type;
        file_put_contents(public_path("/").$file, $image_base64);
        return $file;
    }
}
