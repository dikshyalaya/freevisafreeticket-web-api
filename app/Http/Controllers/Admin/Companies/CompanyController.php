<?php

namespace App\Http\Controllers\Admin\Companies;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyContactPerson;
use App\Models\Industry;
use App\Models\User;
use App\Traits\Admin\AdminMethods;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class CompanyController extends Controller
{
    use AdminMethods;
    public function __construct()
    {
        $this->countries = DB::table('countries')->get();
        $this->industries = Industry::get();
    }
    function list(Request $request) {
        // dd($request->all());
        $companies = Company::when(!blank($request->status), function ($q) use ($request) {
            if ($request->status == 'active') {
                $q->where('is_active', 1);
            } else if ($request->status == 'inactive') {
                $q->where('is_active', 0);
            }

        })->when(!blank($request->country_id), function($q) use($request){
            $q->where('country_id', $request->country_id);
        })->when(!blank($request->start) AND blank($request->end), function($q) use($request){
            $q->where(DB::raw('CAST(created_at as date)'), $request->start);
        })->when(!blank($request->end) AND blank($request->start), function($q) use($request){
            $q->where(DB::raw('CAST(created_at as date)'), $request->end);
        })->when(!blank($request->start) AND !blank($request->end), function($q) use($request){
            $q->orWhereBetween(DB::raw('CAST(created_at as date)'), [$request->start, $request->end]);
        }) ->with('industry')->paginate(10);
        return $this->view('admin.pages.companies.list', [
            'companies' => $companies,
            'countries' => $this->countries,
            // 'companies' => Company::with('industry')->paginate(10),
            // 'companies' => DB::table('companies')->paginate(10)
        ]);
    }
    function new () {
        return $this->view('admin.pages.companies.editadd', [
            'action' => "New",
            'countries' => $this->countries,
            'industries' => $this->industries,
        ]);
    }
    public function create()
    {
        return $this->view('admin.pages.companies.create', [
            'action' => "New",
            'countries' => $this->countries,
            'industries' => $this->industries,
        ]);
    }
    public function edit($id)
    {
        $company = DB::table('companies')->find($id);
        return $this->view('admin.pages.companies.editadd', [
            'company' => $company,
            'contact_person' => DB::table('company_contact_persons')->where(['company_id' => $company->id])->first(),
            'action' => "Edit",
            'countries' => $this->countries,
            'industries' => $this->industries,
        ]);
    }

    public function editCompany($id)
    {
        $company = Company::where('id', $id)->with(['company_contact_person'])->firstOrFail();
        return $this->view('admin.pages.companies.editCompany', [
            'company' => $company,
            'action' => 'Edit',
            'countries' => $this->countries,
            'industries' => $this->industries,
        ]);
    }

    private $Destination = 'uploads/company/';
    private $redirectTo = 'admin.companies.list';

    public function saveCompany(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'company_name' => ['required'],
            'industry_id' => ['required'],
            'ownership' => ['required'],
            'no_of_employee' => ['required'],
            'operating_since' => ['required'],
            'person_designation' => ['required'],
            'full_name' => ['required'],
            'contact_person_designation' => ['required'],
            'company_email' => ['required', 'email'],
            'company_website' => ['nullable', 'url'],
            'company_fb_page' => ['nullable', 'url'],
            'company_logo' => ['nullable', 'image', 'mimes:jpg,png,jpeg'],
            'company_cover' => ['nullable', 'image', 'mimes:jpg,png,jpeg'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        if ($validator->passes()) {
            try {
                \DB::beginTransaction();
                $date = date('Y-m-d');
                $user = new User();
                $user->email = $request->company_email;
                $user->password = Hash::make('12345678');
                $user->user_type = 'company';
                $user->email_verified_at = $date;
                $user->created_at = $date;
                $user->updated_at = $date;
                $user->save();
                $company = new Company();
                $company->user_id = $user->id;
                $company->company_name = $request->company_name;
                if ($request->has('company_logo')) {

                    $logo_input = $request->file('company_logo');
                    $path = $this->Destination.$logo_input->hashName();
                    $image = Image::make($logo_input->getRealPath());
                    $image->resize(500, 500, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($path);
                    $company->company_logo = $path;
//                    $logoName = time() . '_' . $logo->getClientOriginalName();
//                    $company->company_logo = $this->Destination . $logoName;
//                    $logo->move(public_path($this->Destination, 'public'), $logoName);
                }
                if ($request->has('company_cover')) {
                    $cover = $request->file('company_cover');
                    $coverName = time() . '_' . $cover->getClientOriginalName();
                    $company->company_cover = $this->Destination . $coverName;
                    $cover->move(public_path($this->Destination, 'public'), $coverName);
                }
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
                $this->__newContactPerson($company->id, $request);
                \DB::commit();
                return response()->json(['msg' => 'Company created successfully', 'redirectRoute' => route($this->redirectTo)]);
            } catch (\Exception$e) {
                return response()->json(['db_error' => $e->getMessage()]);
            }
        }
    }

    public function updateCompany(Request $request, $id)
    {

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
                    $logo_input = $request->file('company_logo');
                    $path = $this->Destination.$logo_input->hashName();
                    $image = Image::make($logo_input->getRealPath());
                    $image->resize(1000, 1000)->save($path);
//                    $image->resize(1000, 1000, function ($constraint) {
//                        $constraint->aspectRatio();
//                    })->save($path);
                    $company->company_logo = $path;
//                    $logo = $request->file('company_logo');
//                    $logoName = time() . '_' . $logo->getClientOriginalName();
//                    $company->company_logo = $this->Destination . $logoName;
//                    $logo->move(public_path($this->Destination, 'public'), $logoName);
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
                $this->__saveContactPerson($company->id, $request);
                \DB::commit();
                return response()->json(['msg' => 'Company updated successfully', 'redirectRoute' => route($this->redirectTo)]);
            } catch (\Exception$e) {
                return response()->json(['db_error' => $e->getMessage()]);
            }
        }
    }

    private function __newContactPerson($company_id, $request)
    {
        $contact_person = new CompanyContactPerson();
        $contact_person->name = $request->full_name;
        $contact_person->email = $request->contact_person_email;
        $contact_person->phone = $request->contact_person_mobile;
        $contact_person->position = $request->contact_person_designation;
        $contact_person->company_id = $company_id;
        $contact_person->avatar = '';
        $contact_person->person_designation = $request->person_designation;
        $contact_person->isocode = '';
        $contact_person->dialcode = $request->dialcode;
        $contact_person->save();
    }

    private function __saveContactPerson($company_id, $request)
    {
        $contact_person = CompanyContactPerson::where('company_id', $company_id)->first();
        $contact_person->name = $request->full_name;
        $contact_person->email = $request->contact_person_email;
        $contact_person->phone = $request->contact_person_mobile;
        $contact_person->position = $request->contact_person_designation;
        $contact_person->company_id = $company_id;
        $contact_person->avatar = '';
        $contact_person->person_designation = $request->person_designation;
        $contact_person->isocode = '';
        $contact_person->dialcode = $request->dialcode;
        $contact_person->save();
    }

    public function save(Request $request)
    {
        // if($request->company_user_id !== null){
        //     $userData = User::where("id", $request->company_user_id)->first();
        // }
        $request->company_user_id !== null ? $userData = User::where("id", $request->company_user_id)->first() : $userData = '';
        $userData !== '' ? $oldPassword = $userData->password : '';
        $userfield = [];
        $request->company_password ? $userfield['password'] = bcrypt($request->company_password) : $oldPassword;
        // $request->company_password ? $userfield['password'] = bcrypt($request->company_password) : null;
        $userfield['email'] = $request->company_email;
        $user = User::updateOrCreate(['id' => $request->company_user_id], $userfield);
        // dd($user);
        $request->company_logo ? $logofile = time() . '_' . $request->company_logo->getClientOriginalName() : null;
        $request->company_cover ? $coverfile = time() . '_' . $request->company_cover->getClientOriginalName() : null;

        $request->company_logo ? $request->company_logo->move(public_path('uploads/company', 'public'), $logofile) : null;
        $request->company_cover ? $request->company_cover->move(public_path('uploads/company', 'public'), $coverfile) : null;
        $fields = [];
        $request->company_name ? $fields['company_name'] = $request->company_name : null;
        $request->company_logo ? $fields['company_logo'] = 'uploads/company/' . $logofile : null;
        $request->company_cover ? $fields['company_cover'] = 'uploads/company/' . $coverfile : null;
        $request->company_phone ? $fields['company_phone'] = $request->company_phone : null;
        $request->company_email ? $fields['company_email'] = $request->company_email : null;
        $fields['user_id'] = $user->id;
        $request->industry_id ? $fields['industry_id'] = $request->industry_id : null;
        $request->company_details ? $fields['company_details'] = $request->company_details : null;
        $request->company_address ? $fields['company_address'] = $request->company_address : null;
        $request->country_id ? $fields['country_id'] = $request->country_id : null;
        $request->city_id ? $fields['city_id'] = $request->city_id : null;
        $request->is_active ? $fields['is_active'] = $request->is_active == "on" ? true : false : null;
        $request->is_featured ? $fields['is_featured'] = $request->is_featured == "on" ? true : false : null;
        $company = Company::updateOrCreate(['id' => $request->company_id], $fields);

        $contact_person = CompanyContactPerson::updateOrCreate(
            ['company_id' => $company->id],
            [
                "name" => $request->contact_person_name,
                "email" => $request->contact_person_email,
                "phone" => $request->contact_person_phone,
                "position" => $request->contact_person_position,
            ]
        );
        return $this->view('admin.pages.companies.editadd', [
            'company' => $company,
            'contact_person' => $contact_person->first(),
            'action' => "Edit",
            'countries' => $this->countries,
            'industries' => $this->industries,
        ]);
    }
    public function delete($id)
    {
        $company = Company::find($id);
//        dd($company->delete());
        if ($company) {
            $company->company_contact_person()->delete();
            $company->jobs()->delete();
            $company->job_applications()->delete();
            $company->followers()->delete();
            $company->delete();
            return redirect()->back()->with(notifyMsg('success', 'Company deleted successfully'));
        }
        return redirect()->back()->with(notifyMsg('error', 'Company not found'));
        // DB::table('companies')->delete($id);
        // try {
        //     return redirect()
        //         ->route('admin.companies.list')
        //         ->with(['delete' => [
        //             'status' => 'success',
        //         ]]);
        // } catch (\Throwable $th) {
        //     return redirect()
        //         ->route('admin.companies.list')
        //         ->with(['delete' => [
        //             'status' => 'failed',
        //         ]]);
        // }
    }

    public function show($id)
    {
        $company = Company::where('id', $id)->with(['industry', 'company_contact_person', 'user'])->firstOrFail();
        return $this->view('admin.pages.companies.showCompany', [
            'company' => $company,
            'editRoute' => route('admin.companies.editCompany', $company->id),

        ]);
        // return $this->view('admin.pages.companies.show', ['company' => $company]);
    }
}
