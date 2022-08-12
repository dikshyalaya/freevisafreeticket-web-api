<?php

namespace App\Http\Controllers\Candidates;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Country;
use App\Models\Employe;
use App\Models\EmployJobPreference;
use App\Models\JobApplication;
use App\Models\News;
use App\Models\SavedJob;
use App\Models\Training;
use App\Models\User;
use App\Traits\Site\CandidateMethods;
use App\Traits\Site\ThemeMethods;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DashController extends Controller
{
    use ThemeMethods;
    use CandidateMethods;
    public function __construct()
    {
        $this->middleware('auth');
        $this->experiencelevels = \DB::table('experiencelevels')->get();
        $this->educationlevels = \DB::table('educationlevels')->get();
        $this->job_shifts = \DB::table('job_shifts')->get();
        // $this->job_categories = \DB::table('job_categories')->get();
        // $this->countries = \DB::table('countries')->get();
        $this->trainings = Training::get();
        $this->skills = \DB::table('skills')->get();
        $this->states = \DB::table('states')->get();
        $this->languages = \DB::table('languages')->get();
        $this->jobs = \DB::table('jobs')->get();
        $this->Countries = Country::whereHas('jobs')->select('id', 'name', 'iso2', 'iso3')->withCount('jobs')->take(6)->get();
    }

    public function dashboard()
    {
        $employe = Employe::where('user_id', auth()->user()->id)->first();
        $saved_jobs = SavedJob::where('employ_id', $this->employe()->id)->orderBy('id', 'DESC')->take(2)->with(['job', 'job.company:id,company_name', 'job.country:id,name,iso2,iso3,currency'])->get();
        return $this->client_view('candidates.dash', [
            "totals" => [
                [
                    'title' => 'Applied Jobs',
                    'links' => route('candidate.jobs'),
                    'total' => $this->applications(new JobApplication())->where('employ_id', $employe->id)->count(),
                ],
                [
                    'title' => 'Saved Jobs',
                    'links' => route('candidate.savedjob.saveJobLists'),
                    'total' => $this->applications(new SavedJob())->where('employ_id', $employe->id)->count(),
                ],
            ],
            "application_datas" => $this->__datas()['application_datas'],
            "profile_datas" => $this->__datas()['profile_datas'],
            'saved_jobs' => $saved_jobs,
            'Countries' => $this->Countries,
            'news' => News::orderBy('id', 'DESC')->take(3)->get(),
        ]);
    }

    private function __route($type)
    {
        return route('candidate.job_application.index', $type);
    }

    private function __datas()
    {
        /* TODO work with stdClass to create multiple object instance */
        return [
            'application_datas' => [
                [
                    'title' => 'All Applications',
                    'link' => $this->__route('all-applications'),
                    'totalcount' => $this->employe()->job_applications->count(),
                    'image' => 'mail.svg',
                    'bg-color' => 'bg-blue',
                ],
                [
                    'title' => 'Unscreened Applications',
                    'link' => $this->__route('unscreened-applications'),
                    'totalcount' => $this->employe()->job_applications->where('status', 'pending')->count(),
                    'image' => 'megaphone.svg',
                    'bg-color' => 'bg-gray',
                ],
                [
                    'title' => 'Shortlisted Applications',
                    'link' => $this->__route('shortlisted-applications'),
                    'totalcount' => $this->employe()->job_applications->where('status', 'shortlisted')->count(),
                    'image' => 'blogging.svg',
                    'bg-color' => 'bg-pink',
                ],
                [
                    'title' => 'Interviewed Applications',
                    'link' => $this->__route('interviewed-applications'),
                    'totalcount' => $this->employe()->job_applications->where('status', 'selectedForInterview')->count(),
                    'image' => 'picture.svg',
                    'bg-color' => 'bg-orange',
                ],
                [
                    'title' => 'Selected Applications',
                    'link' => $this->__route('selected-applications'),
                    'totalcount' => $this->employe()->job_applications->where('status', 'accepted')->count(),
                    'image' => 'picture.svg',
                    'bg-color' => 'bg-green',
                ],
                [
                    'title' => 'Rejected Applications',
                    'link' => $this->__route('rejected-applications'),
                    'totalcount' => $this->employe()->job_applications->where('status', 'rejected')->count(),
                    'image' => 'box-closed.svg',
                    'bg-color' => 'bg-red',
                ],
            ],
            "profile_datas" => [
                [
                    'title' => 'My Profile',
                    'link' => route('candidate.profile.index'),
                    'totalcount' => '',
                    'icon' => '/uploads/site/svgs/jobs/businessman-white.svg',
                ],
                [
                    'title' => 'My CV',
                    'link' => route('candidate.profile.get_cv'),
                    'totalcount' => '',
                    'icon' => '/uploads/site/svgs/post-it.svg',
                ],
                [
                    'title' => 'Message',
                    'link' => '#',
                    'totalcount' => '',
                    'icon' => '/uploads/site/svgs/mail.svg',
                ],
                [
                    'title' => 'Notification',
                    'link' => route('candidate.get-notifications'),
                    'totalcount' => Auth::user()->unReadNotifications->count() ?: '',
                    'icon' => '/uploads/site/svgs/megaphone.svg',
                ],
            ],
        ];
    }

    private function applications($model)
    {
        return get_class($model)::query();
    }

    public function jobs()
    {

        $all_jobs = $this->jobsquery('all', false);
        $rejected_jobs = $this->jobsquery('rejected');
        $pending_jobs = $this->jobsquery('pending');
        $accepted_jobs = $this->jobsquery('accepted');
        $fields = [
            'all_jobs' => $all_jobs,
            'rejected_jobs' => $rejected_jobs,
            'pending_jobs' => $pending_jobs,
            'accepted_jobs' => $accepted_jobs,
        ];
        if (auth()->check()) {
            $employ = Employe::where('user_id', auth()->user()->id)->first();
            $fields['employ'] = $employ;
        }
        return $this->client_view('candidates.jobs', $fields);
    }
    public function profile()
    {
        $educationlevels = DB::table('educationlevels')->get();
        $experiencelevels = DB::table('experiencelevels')->get();
        $employ = Employe::where('user_id', \Auth::user()->id)->first();
        return $this->client_view('candidates.profile', [
            'employ' => $employ,
            'educationlevels' => $educationlevels,
            'experiencelevels' => $experiencelevels,
            // 'countries' => $this->countries,
            'educationLevels' => $this->educationlevels,
            'states' => $this->states,
            'skills' => $this->skills,
            'trainings' => $this->trainings,
            'languages' => $this->languages,
            // 'job_categories' => $this->job_categories,
            'jobs' => $this->jobs,
            'employ_experiences' => DB::table('employes_experience')->where("employ_id", $employ->id)->get(),
            'viewRoute' => route('candidate.profile.show', $employ->id),
        ]);
    }
    public function saveProfile(Request $request)
    {
        $employ = DB::table('employes')->where('user_id', auth()->user()->id);
        $fields = [];
        $request->has('first_name') ? $fields['first_name'] = $request->first_name : null;
        $request->has('middle_name') ? $fields['middle_name'] = $request->middle_name : null;
        $request->has('last_name') ? $fields['last_name'] = $request->last_name : null;
        $request->has('dob') ? $fields['dob'] = $request->dob : null;
        $request->has('gender') ? $fields['gender'] = $request->gender : null;
        $request->has('marital_status') ? $fields['marital_status'] = $request->marital_status : null;
        $request->has('nationality') ? $fields['nationality'] = $request->nationality : null;
        $request->has('country_id') ? $fields['country_id'] = $request->country_id : null;
        $request->has('state_id') ? $fields['state_id'] = $request->state_id : null;
        $request->has('city_id') ? $fields['city_id'] = $request->city_id : null;
        $request->has('tel_phone') ? $fields['tel_phone'] = $request->tel_phone : null;
        $request->has('mobile_phone') ? $fields['mobile_phone'] = $request->mobile_phone : null;
        $employ->update($fields);
        return $this->profile();
    }
    public function job_preferences()
    {
        $employ = DB::table('employes')->where('user_id', auth()->user()->id)->first();
        $employ_job_preference = DB::table('employ_job_preference')->where('employ_id', $employ->id)->first();
        // dd($employ_job_preference);
        $educationlevels = DB::table('educationlevels')->get();
        $experiencelevels = DB::table('experiencelevels')->get();
        $job_categories = DB::table('job_categories')->get();
        return $this->client_view('candidates.job-preferences', [
            'educationlevels' => $educationlevels,
            'experiencelevels' => $experiencelevels,
            'job_categories' => $job_categories,
            'employ_job_preference' => $employ_job_preference,
        ]);
    }
    public function saveJobPreferences(Request $request)
    {

        $employ = Employe::where('user_id', auth()->user()->id)->first();
        $fields = [];
        $request->has('job_category_id') ? $fields['job_category_id'] = $request->job_category_id : null;
        $request->has('country_id') ? $fields['country_id'] = $request->country_id : null;
        EmployJobPreference::updateOrCreate(['employ_id' => $employ->id], $fields);
        return $this->job_preferences();
    }

    private function jobsquery($status, $filter = true)
    {
        $employ = Employe::where('user_id', auth()->user()->id)->first();
        $jobs = DB::table('jobs')
            ->join('job_applications', 'jobs.id', '=', 'job_applications.job_id')
            ->where('job_applications.employ_id', $employ->id);
        if ($filter) {
            $jobs->where('job_applications.status', $status);
        }
        return $jobs->paginate(10);
    }
    public function settings()
    {
        return $this->client_view('candidates.settings');
    }
    public function saveSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'min:8'],
            'confirm-password' => ['required', 'same:password'],
        ], [
            'password.required' => 'Password is required',
            'password.min' => 'Password must be 8 characters',
            'confirm-password.required' => 'Confirm Password field is required',
            'confirm-password.same' => 'Confirm password didn\'t match with password',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $fields = [];
        $user = User::find(auth()->user()->id);
        // $request->has('email') ? $fields['email'] = $request->email : null;
        $request->has('password') ? $fields['password'] = bcrypt($request->password) : null;
        $user->update($fields);
        return redirect()->back()->with(notifyMsg('success', 'Password changed successfully'));
        // return $this->client_view('candidates.settings')->with(notifyMsg('message', 'Password changed successfully'));
    }
    public function applyjob($id)
    {
        if (auth()->check() && auth()->user()->user_type == "candidate") {
            $employ = Employe::where('user_id', auth()->user()->id)->first();
            // $employ = \DB::table('employes')->where('user_id', auth()->user()->id)->first();
            $is_exist = \DB::table("job_applications")->where('job_id', $id)->where('employ_id', $employ->id)->first();
            if ($employ->calculateProfileCompletion() > 50) {
                if (!$is_exist) {
                    \DB::table("job_applications")->insert([
                        "job_id" => $id,
                        "employ_id" => $employ->id,
                    ]);
                } else {
                    return redirect()->route('candidate.dashboard')->with(notifyMsg('warning', 'You have already applied for this job'));
                }
            } else {
                return redirect()->route('candidate.profile.get_personal_information')->with(notifyMsg('warning', 'You are not eligible to apply for job. Please Complete your profile first'));
            }

        }
        return redirect()->back()->with(swalNotify('Thank you for applying for the job. Please check your profile regularly for application status.', 'success', 'You applied for job'));
        // return redirect()->back()->with('swalMessage', 'Thank you for applying for the job. Please check your profile regularly for application status.');
        // return redirect()->route('candidate.dashboard')->with(notifyMsg('success', 'Successfully applied for job'));
    }
    public function removeApplication($id)
    {
        if (auth()->check() && auth()->user()->user_type == "candidate") {
            $employ = \DB::table('employes')->where('user_id', auth()->user()->id)->first();
            $job_application = DB::table('job_applications')->where(["employ_id" => $employ->id, "job_id" => $id]);
            $job_application->delete();
            return redirect()->back();
        }
    }

    public function saveJob($id)
    {
        if (authIsCandidate()) {

        }
    }

    private $destination = 'uploads/candidates/profiles/';
    private $fullPictureDestination = 'uploads/candidates/full_picture/';
    private $redirectTo = "candidate.profile";

    public function show($id)
    {
        $employ = Employe::where('user_id', \Auth::user()->id)->first();
        return $this->client_view('candidates.show', [
            'action' => "View",
            'employ' => $employ,
            'editRoute' => route('candidate.profile'),
        ]);
    }

    public function company_lists()
    {
        $employ = Employe::where('user_id', \Auth::user()->id)->first();
        if (!$employ->job_preferences->isEmpty()) {
            $companies = Company::whereIn('country_id', $employ->countryPreference()->pluck('job_preference_id')->toArray())->get();
            $companys = Company::whereHas('jobs', function ($query) use ($employ) {
                return $query->whereIn('job_categories_id', $employ->jobCategoryPreference()->pluck('job_preference_id')->toArray());
            })->get();
            $companies = paginateCollection($companies->merge($companys), 12);
            // $companies = $this->paginate($companies->merge($companys), 12);
        } else {
            $companies = Company::whereHas('jobs')->paginate(12);
        }
        // $job_id = $employ->job_applications()->pluck('job_id');
        // $companies_id = Job::whereIn('id', $job_id)->pluck('company_id')->toArray();
        // $unique_company_id = getApplicantCompanyList($employ);
        // $companies = Company::whereIn('id', $unique_company_id)->get();
        // $companies = Company::whereHas('jobs', function ($query) {
        //     return $query->whereHas('job_applications', function ($query2) {
        //         $query2->whereHas('employe', function ($query3) {
        //             return $query3->where('user_id', Auth::user()->id);
        //         });
        //     });
        // })->paginate(12); Do not delete the query
        return $this->client_view('candidates.company_list', [
            'companies' => $companies,
            // 'companies' => Company::whereIn('id', $unique_company_id)->paginate(12),
        ]);
    }

    public function view_company_detail($id)
    {
        return $this->client_view('candidates.company_detail', [
            'company' => Company::where('id', $id)->with(['company_contact_person'])->first(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $employe = Employe::where('id', $id)->first();
        $validator = Validator::make($request->all(), [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'english_dob' => ['required'],
            'nepali_dob' => ['required'],
            'gender' => ['required'],
            'marital_status' => ['required'],
            'education_level_id' => ['required'],
            'mobile_number1' => ['required'],
            'email' => ['required', 'unique:users,email,' . $employe->user_id],
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:12096'],
            'full_picture' => ['nullable'],
            'full_picture.*' => ['image', 'mimes:jpeg,png,jpg', 'max:12096'],
        ], [
            'first_name.required' => 'The first name field is required',
            'last_name.required' => 'The last name field is required',
            'english_dob.required' => 'Date of birth field is required',
            'nepali_dob.required' => 'Date of birth field is required',
            'education_level_id.required' => 'The education level field is required',
            'mobile_number1.required' => 'The mobile number field is required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        if ($validator->passes()) {
            try {
                \DB::beginTransaction();
                $user = User::find($employe->user_id);
                $user->email = $request->email;
                $user->update([
                    'email' => $request->email,
                    'user_type' => 'candidate',
                ]);
                $this->__updateEmployee($id, $user->id, $request);
                \DB::commit();
                return response()->json(['msg' => 'Candidate updated successfully', 'redirectRoute' => route($this->redirectTo)]);
            } catch (\Exception$e) {
                \DB::rollBack();
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
            $photoData = [];
            foreach ($request->file('full_picture') as $file) {
                $photoName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path($this->fullPictureDestination, 'public'), $photoName);
                $photoData[] = $this->fullPictureDestination . $photoName;
            }
//            $employe->full_picture = json_encode($photoData);
            $employe->full_picture = json_encode(array_merge(
                $photoData,
                json_decode($employe->full_picture, true)
            ));
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
                        'job_title_id' => $request->get('job_title')[$key],
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
                    $fields['job_title_id'] = $request->get('job_title')[$key];
                    $fields['working_year'] = $request->get('working_year')[$key];
                    $fields['working_month'] = $request->geT('working_month')[$key];
                    DB::table('employes_experience')->insert($fields);
                }

            }

        }
    }

    private function __updateEmployeSkill($employ_id, $request)
    {
        DB::table('employes_skills')->where('employ_id', $employ_id)->delete();
        $fields = [];
        if (isset($request->skill) and !blank($request->skill)) {
            foreach ($request->skill as $key => $skill) {
                $fields['employ_id'] = $employ_id;
                $fields['skills_id'] = $skill;
                \DB::table('employes_skills')->insert($fields);
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

    public function follow_company(Request $request)
    {
        if ($request->ajax()) {
            try {
                DB::beginTransaction();
                $employ = Employe::where('user_id', auth()->id())->first();
                $input['employ_id'] = $request->employ_id;
                $input['company_id'] = $request->company_id;
                $input['followed_time'] = Carbon::now();
                if (count($employ->followings->where('company_id', $request->company_id)) == 0) {
                    $employ->followings()->updateOrCreate($input);
                    $company = Company::where('id', $request->company_id)->first();
                    $follower_count = $company->followers->count();
                    DB::commit();
                    return response()->json(['msg' => "Followed successfully", 'alreadyFollowed' => false, 'followers' => $follower_count]);
                } else {
                    return response()->json(['msg' => "Already followed", "alreadyFollowed" => true]);
                }

            } catch (\Exception$e) {
                DB::rollBack();
                return response()->json(['db_error' => $e->getMessage()]);
            }
        }
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function getNotifications()
    {
        return $this->client_view('candidates.notifications', []);
    }
}
