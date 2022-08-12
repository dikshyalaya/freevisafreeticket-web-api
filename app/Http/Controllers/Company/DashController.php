<?php

namespace App\Http\Controllers\company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyContactPerson;
use App\Models\Employe;
use App\Models\Industry;
use App\Models\Job;
use App\Models\User;
use App\Traits\Site\CompanyMethods;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class DashController extends Controller
{
    use CompanyMethods;
    public function __construct()
    {
        $this->experiencelevels = \DB::table('experiencelevels')->get();
        $this->educationlevels = \DB::table('educationlevels')->get();
        $this->job_shifts = \DB::table('job_shifts')->get();
        $this->job_categories = \DB::table('job_categories')->get();
        $this->countries = \DB::table('countries')->get();
        $this->industries = Industry::get();
    }
    public function dashboard()
    {
        // dd(json_encode($this->__getChartData()['genderCount']));
        return $this->company_view('company.dash', [
            "job_datas" => $this->__datas()['job_datas'],
            "profile_datas" => $this->__datas()['profile_datas'],
            "application_datas" => $this->__datas()['application_datas'],
            'genderDatas' => $this->__getChartData()['genderCount'],
            'ageDatas' => $this->__getChartData()['age_group'],
        ]);
    }

    private function __route($type)
    {
        return route('company.jobs', ['type' => $type]);
    }

    private function __datas()
    {
        return [
            'job_datas' => [
                [
                    'title' => 'Total Jobs',
                    'link' => $this->__route('all'),
                    'totalcount' => ($this->company()) ? $this->company()->jobs->count() : '',
                    'image' => 'mail.svg',
                    'bg-color' => 'bg-blue',
                ],
                [
                    'title' => 'Drafted Jobs',
                    'link' => $this->__route('draft_jobs'),
                    'totalcount' => ($this->company()) ? $this->company()->jobs->where('status', 'Draft')->count() : '',
                    'image' => 'megaphone.svg',
                    'bg-color' => 'bg-gray',
                ],
                [
                    'title' => 'Pending Jobs',
                    'link' => $this->__route('pending_jobs'),
                    'totalcount' => ($this->company()) ? $this->company()->jobs->where('status', 'Pending')->count() : '',
                    'image' => 'blogging.svg',
                    'bg-color' => 'bg-pink',
                ],
                [
                    'title' => 'Published Jobs',
                    'link' => $this->__route('published_jobs'),
                    'totalcount' => ($this->company()) ? $this->company()->jobs->where('status', 'Published')->count() : '',
                    'image' => 'picture.svg',
                    'bg-color' => 'bg-orange',
                ],
                [
                    'title' => 'Expired Jobs',
                    'link' => $this->__route('expired_jobs'),
                    'totalcount' => ($this->company()) ? $this->company()->jobs->where('status', 'Expired')->count() : '',
                    'image' => 'picture.svg',
                    'bg-color' => 'bg-green',
                ],
                [
                    'title' => 'Rejected Jobs',
                    'link' => $this->__route('rejected_jobs'),
                    'totalcount' => ($this->company()) ? $this->company()->jobs->where('status', 'Rejected')->count() : '',
                    'image' => 'box-closed.svg',
                    'bg-color' => 'bg-red',
                ],
            ],
            "profile_datas" => [
                [
                    'title' => 'Post New Job',
                    'link' => route('company.newjob.get_job_detail'),
                    'totalcount' => '',
                    'icon' => '/uploads/site/svgs/jobs/upload-white.svg',
                ],
                [
                    'title' => 'Search Applicants',
                    'link' => route('company.applicant.index'),
                    'totalcount' => '',
                    'icon' => '/uploads/site/svgs/jobs/user-white.svg',
                ],
                [
                    'title' => 'New Message',
                    'link' => '#',
                    'totalcount' => '',
                    'icon' => '/uploads/site/svgs/mail.svg',
                ],
                [
                    'title' => 'Notifications',
                    'link' => route('company.get-notifications'),
                    'totalcount' => Auth::user()->unReadNotifications->count() ?: '',
                    'icon' => '/uploads/site/svgs/megaphone.svg',
                ],
            ],
            'application_datas' => [
                [
                    'title' => 'All Applications',
                    'link' => route('company.applicant.index'),
                    'totalcount' => ($this->company()) ? $this->company()->job_applications->count() : '',
                    'image' => 'mail.svg',
                    'bg-color' => 'bg-blue',
                ],
                [
                    'title' => 'Unscreened Applications',
                    'link' => route('company.applicant.index'),
                    'totalcount' => ($this->company()) ? $this->company()->job_applications->where('status', 'pending')->count() : '',
                    'image' => 'megaphone.svg',
                    'bg-color' => 'bg-gray',
                ],
                [
                    'title' => 'Shortlisted Applications',
                    'link' => route('company.applicant.index'),
                    'totalcount' => ($this->company()) ? $this->company()->job_applications->where('status', 'shortlisted')->count() : '',
                    'image' => 'blogging.svg',
                    'bg-color' => 'bg-pink',
                ],
                [
                    'title' => 'Interviewed Applications',
                    'link' => route('company.applicant.index'),
                    'totalcount' => ($this->company()) ? $this->company()->job_applications->where('status', 'selectedForInterview')->count() : '',
                    'image' => 'picture.svg',
                    'bg-color' => 'bg-orange',
                ],
                [
                    'title' => 'Selected Applications',
                    'link' => route('company.applicant.index'),
                    'totalcount' => ($this->company()) ? $this->company()->job_applications->where('status', 'accepted')->count() : '',
                    'image' => 'picture.svg',
                    'bg-color' => 'bg-green',
                ],
                [
                    'title' => 'Rejected Applications',
                    'link' => route('company.applicant.index'),
                    'totalcount' => ($this->company()) ? $this->company()->job_applications->where('status', 'rejected')->count() : '',
                    'image' => 'box-closed.svg',
                    'bg-color' => 'bg-red',
                ],
            ],
        ];
    }
    public function profile()
    {
        $GLOBALS['page-name'] = 'Profile';
        $company = @Company::where('user_id', \Auth::user()->id)->first();
        $contact_person = @DB::table('company_contact_persons')->where('company_id', $company->id)->first();
        return $this->company_view('company.profile', [
            'contact_person' => $contact_person,
            'industries' => $this->industries,
            'countries' => $this->countries,
            'viewRoute' => route('company.view_profile'),
        ]);
    }
    public function saveProfile(Request $request)
    {
        $request->validate([
            'company_name' => 'required|max:255',
            'company_logo' => 'nullable|image|mimes:jpg,png,jpeg,|max:99999|dimensions:min_width=100,min_height=100',
            'company_cover' => 'nullable|image|mimes:jpg,png,jpeg|max:99999|dimensions:min_width=100,min_height=100',
        ]);

        $company = Company::where('id', $request->company_id)->where('user_id', auth()->user()->id)->firstOrFail();
        $company->company_name = $request->company_name;
        $company->company_phone = $request->company_phone;
        $company->company_email = $request->company_email;
        $company->industry_id = $request->industry_id;
        $company->company_details = $request->company_details;
        $company->company_address = $request->company_address;
        $company->country_id = $request->country_id;
        $company->city_id = $request->city_id;
        $company->is_active = $request->is_active == "on" ? true : false;
        $company->company_details = $request->company_details;

        $upload_path = 'uploads/company/';

        // Remove old file if exist
        // ....

        if ($request->hasFile('company_logo')) {
            $logofile = time() . '_' . $request->company_logo->getClientOriginalName();
            $request->company_logo->move(public_path($upload_path, 'public'), $logofile);
            $company->company_logo = $upload_path . $logofile;
        }
        if ($request->hasFile('company_cover')) {
            $coverfile = time() . '_' . $request->company_cover->getClientOriginalName();
            $request->company_cover->move(public_path($upload_path, 'public'), $coverfile);
            $company->company_cover = $upload_path . $coverfile;
        }
        $company->save();
        CompanyContactPerson::updateOrCreate(
            ['company_id' => $company->id],
            [
                "name" => $request->contact_person_name,
                "email" => $request->contact_person_email,
                "phone" => $request->contact_person_phone,
                "position" => $request->contact_person_position,
            ]
        );

        return redirect()->route('company.edit_profile');
    }

    public function applicants()
    {
        return $this->company_view('company.applicants');
    }

    public function jobs(Request $request)
    {
        $GLOBALS['page-name'] = 'Job';
        $company = Company::where('user_id', auth()->user()->id)->first();
        if ($request->filled('term')) {
            $all_jobs = Job::filterjob($request->term)->where('company_id', $company->id)->paginate(10);
        } else {
            $all_jobs = $this->jobsquery('all', false);
        }

        $approved_jobs = $this->jobsquery('Approved');
        $unapproved_jobs = $this->jobsquery('Not Approved');
        $published_jobs = $this->jobsquery('Published');
        $expired_jobs = $this->jobsquery('Expired');
        $draft_jobs = $this->jobsquery('Draft');
        $pending_jobs = $this->jobsquery('Pending');
        $active_jobs = $this->jobsquery('Active');
        $rejected_jobs = $this->jobsquery('Rejected');
        // $published_jobs = Job::where('publish_status', 1)->where('company_id', $company->id)->paginate(10);
        // $expired_jobs = Job::where('is_expired', 1)->where('company_id', $company->id)->paginate(10);
        // $draft_jobs = Job::where('draft_status', 1)->where('company_id', $company->id)->paginate(10);
        // $pending_jobs = Job::where('is_active', 0)->where('company_id', $company->id)->paginate(10);
        // $active_jobs = Job::where('is_active', 1)->where('company_id', $company->id)->paginate(10);
        $fields = [
            'all_jobs' => $all_jobs,
            'approved_jobs' => $approved_jobs,
            'unapproved_jobs' => $unapproved_jobs,
            'published_jobs' => $published_jobs,
            'expired_jobs' => $expired_jobs,
            'draft_jobs' => $draft_jobs,
            'pending_jobs' => $pending_jobs,
            'active_jobs' => $active_jobs,
            'rejected_jobs' => $rejected_jobs,
        ];
        if (auth()->check()) {
            $company = Company::where('user_id', auth()->user()->id)->first();
            $fields['company'] = $company;
        }
        return $this->company_view('company.jobs', $fields);
    }

    public function show()
    {
        $company = Company::where('user_id', \Auth::user()->id)->with(['industry', 'company_contact_person', 'user'])->firstOrFail();
        return $this->company_view('company.showProfile', ['company' => $company, 'editRoute' => route('company.edit_profile')]);
    }

    private $Destination = 'uploads/company/';
    private $redirectTo = 'company.edit_profile';

    public function updateProfile(Request $request, $id)
    {
//         dd($request->all());
        $validator = Validator::make($request->all(), [
            'company_name' => ['required'],
            'industry_id' => ['required'],
            'ownership' => ['required'],
            'no_of_employee' => ['required'],
            'operating_since' => ['required'],
            'person_designation' => ['required'],
            'full_name' => ['required'],
            'contact_person_designation' => ['required'],
            'company_email' => ['nullable', 'email'],
            'company_website' => ['nullable', 'url'],
            'company_fb_page' => ['nullable', 'url'],
            'company_logo' => ['nullable', 'image', 'mimes:jpg,png,jpeg'],
            'company_cover' => ['nullable', 'image', 'mimes:jpg,png,jpeg'],
        ],[
            'full_name.required' => 'The full name is required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        if ($validator->passes()) {
            try {
                \DB::beginTransaction();
                $company = Company::where('id', $id)->first();
                $oldLogo = $company->company_logo;
                $oldCover = $company->company_cover;
                $company_user_id = $company->user_id;
                $company->company_name = $request->company_name;
                if ($request->has('company_logo')) {
                    $logo = $request->file('company_logo');
                    $logoName = time() . '_' . $logo->getClientOriginalName();
                    $company->company_logo = $this->Destination . $logoName;
                    $logo->move(public_path($this->Destination, 'public'), $logoName);
                } else {
                    $company->company_logo = $oldLogo;
                }
                if ($request->has('company_cover')) {
                    $cover = $request->file('company_cover');
                    $coverName = time() . '_' . $cover->getClientOriginalName();
                    $company->company_cover = $this->Destination . $coverName;
                    $cover->move(public_path($this->Destination, 'public'), $coverName);
                } else {
                    $company->company_cover = $oldCover;
                }

                $company->user_id = $company_user_id;
                $company->company_phone = $request->mobile_phone1;
                $company->company_email = $request->company_email;
                $company->industry_id = $request->industry_id;
                $company->company_details = $request->company_introduction;
                $company->country_id = $request->country_id;
                $company->state_id = $request->state_id;
                $company->city_id = $request->city_id;
                $company->company_address = $request->company_address;
                $company->is_active = $request->is_active != null ? 1 : 0;
                $company->is_featured = $request->is_featured != null ? 1 : 0;
                $company->company_website = $request->company_website;
                $company->company_fb_page = $request->company_fb_page;
                $company->ownership = $request->ownership;
                $company->no_of_employee = $request->no_of_employee;
                $company->operating_since = $request->operating_since;
                $company->company_services = $request->company_services;
                $company->isocode1 = '';
                $company->isocode2 = '';
                $company->dialcode1 = $request->dial_code;
                $company->dialcode2 = '';
                $company->mobile_phone1 = $request->mobile_phone1;
                $company->mobile_phone2 = $request->mobile_phone2;
                $company->html_content_intro = $request->html_content_intro;
                $company->html_content_service = $request->html_content_service;
                $company->save();
                $this->__updateContactPerson($company->id, $request);
                \DB::commit();
                return response()->json(['msg' => 'Company updated successfully', 'redirectRoute' => route($this->redirectTo)]);
            } catch (\Exception $e) {
                return response()->json(['db_error' => $e->getMessage()]);
            }
        }
    }

    private function __updateContactPerson($company_id, $request)
    {
        // $contact_person = CompanyContactPerson::where('company_id', $company_id)->first();
        // $contact_person->name = $request->full_name;
        // $contact_person->email = $request->contact_person_email;
        // $contact_person->phone = $request->contact_person_mobile;
        // $contact_person->position = $request->contact_person_designation;
        // $contact_person->company_id = $company_id;
        // $contact_person->avatar = '';
        // $contact_person->person_designation = $request->person_designation;
        // $contact_person->isocode = '';
        // $contact_person->dialcode = $request->dialcode;
        // $contact_person->save();

        CompanyContactPerson::updateOrCreate([
            'company_id' => $company_id
        ],[
            'name' => $request->full_name,
            'email' => $request->contact_person_email,
            'phone' => $request->contact_person_mobile,
            'position' => $request->contact_person_designation,
            'company_id' => $company_id,
            'avatar' => '',
            'person_designation' => $request->person_designation,
            'isocode' => '',
            'dialcode' => $request->dialcode
        ]);
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
        ];
        return $this->company_view('company.editjob', $fields);
    }

    private function jobsquery($status, $filter = true)
    {

        $company = Company::where('user_id', auth()->user()->id)->first();
        $jobs = Job::where('company_id', $company->id);
        if ($filter) {
            $jobs->where('status', $status);

        }
        return $jobs->paginate(10);
    }

    public function settings()
    {
        $GLOBALS['page-name'] = 'Setting';
        return $this->company_view('company.settings', [
            'user' => \Auth::user(),
        ]);
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

    private function __getChartData()
    {
        $company = Company::where('user_id', auth()->user()->id)->with(['job_applications.employe'])->first();
        $employe_ids = [];
        if($company) {
            foreach ($company->job_applications as $job_application) {
                $employe_ids[] = $job_application->employe->id;
            }
        }
        $male_count = Employe::whereIn('id', $employe_ids)->where('gender', 'Male')->count();
        $female_count = Employe::whereIn('id', $employe_ids)->where('gender', 'Female')->count();
        $other_count = Employe::whereIn('id', $employe_ids)->where('gender', 'Other')->count();
        $below20 = Employe::whereIn('id', $employe_ids)->where(DB::raw('TIMESTAMPDIFF(YEAR,dob,CURDATE())'), '<', 20)->count();
        $age_20_30 = Employe::whereIn('id', $employe_ids)->whereBetween(DB::raw('TIMESTAMPDIFF(YEAR,dob,CURDATE())'), [20,30])->count();
        $age_31_40 = Employe::whereIn('id', $employe_ids)->whereBetween(DB::raw('TIMESTAMPDIFF(YEAR,dob,CURDATE())'), [31,40])->count();
        $above40 = Employe::whereIn('id', $employe_ids)->where(DB::raw('TIMESTAMPDIFF(YEAR,dob,CURDATE())'), '>', 40 )->count();
        return [
            'genderCount' =>[
                'genders' => [
                    'male' => $male_count,
                    'female' => $female_count,
                    'other' => $other_count,
                ],
                'colors' => [
                    'male' => '#4801FF',
                    'female' => '#3495eb',
                    'other' => '#ec296b',
                ],
                'names' => [
                    'male' => 'Male',
                    'female' => 'Female',
                    'other' => 'Other',
                ],
            ],
            'age_group' => [
                'ages' => [
                    'below20' => $below20,
                    '20-30' => $age_20_30,
                    '31-40' => $age_31_40,
                    'above40' => $above40,
                ],
                'colors' => [
                    'below20' => '#4801FF',
                    '20-30' => '#3495eb',
                    '31-40' => '#ed3b47',
                    'above40' => '#ec296b',
                ],
                'names' => [
                    'below20' => 'Below 20',
                    '20-30' => 'Age Group 20-30',
                    '31-40' => 'Age Group 31-40',
                    'above40' => 'Above 40',
                ],
            ],
        ];

    }

    public function removeImage(Request $request)
    {
        $request->validate([
            'company_id' => 'required',
            'name' => 'required',
        ]);

        try{
            $company = Company::findOrFail($request->company_id);
            if ($request->name === 'company_logo'){
                $company->company_logo = '';
            }
            elseif($request->name === 'company_cover'){
                $company->company_cover = '';
            }

            $company->save();
            return response()->json(['error' => false, 'message' => 'Image removed successfully']);

        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()]);

        }
    }

    public function getNotifications()
    {
        return $this->company_view('company.notifications', []);
    }
}
