<?php

namespace App\Http\Controllers\Candidates;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Employe;
use App\Models\User;
use App\Rules\MatchOldPassword;
use App\Traits\Site\CandidateMethods;
use App\Traits\Site\ThemeMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SettingController extends Controller
{
    use ThemeMethods, CandidateMethods;
    private $page = "candidates.setting.account_setting.";

    public function __construct()
    {
        $this->middleware('auth');
        $this->countries = Country::get();
    }

    public function get_setting()
    {
        return $this->client_view($this->page . 'index', [
            'employ' => $this->employe(['user']),
            'countries' => $this->countries,
        ]);
    }

    public function update_setting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => [Rule::requiredIf($request->has('first_name'))],
            'last_name' => [Rule::requiredIf($request->has('last_name'))],
            'gender' => [Rule::requiredIf($request->has('gender'))],
            'mobile_phone' => [Rule::requiredIf($request->has('mobile_phone'))],
            'country_id' => [Rule::requiredIf($request->has('country_id'))],
            'state_id' => [Rule::requiredIf($request->has('state_id'))],
            'district_id' => [Rule::requiredIf($request->has('district_id'))],
            'website' => ['nullable', 'url'],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $employ = $this->employe();
                if($request->filled('password')){
                    $password = Hash::make($request->password);
                    $employ->user->update(['password' => $password]);
                }
                $employ->update([
                    'bio' => $request->has('bio') ? $request->bio : ($request->has('about_me') ? $request->about_me : ''),
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'gender' => $request->gender,
                    'mobile_phone' => $request->mobile_phone,
                    'country_id' => $request->country_id,
                    'state_id' => $request->state_id,
                    'district_id' => $request->district_id,
                    'website' => $request->website,
                    'municipality' => $request->municipality,
                ]);
                DB::commit();
                return response()->json(['msg'=>'Employe updated successfully', 'redirectRoute' => route('candidate.account_setting.index')]);
            } catch (\Exception$e) {
                DB::rollBack();
                return response()->json(['db_error' => $e->getMessage()]);
            }
        }
    }

    public function get_change_password()
    {
        return $this->client_view($this->page.'get_change_password');
    }

    public function post_change_password(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'old_password' => ['required', new MatchOldPassword()],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }
        if($validator->passes()){
            try{
                DB::beginTransaction();
                User::find(Auth::user()->id)->update(['password' => Hash::make($request->password)]);
                DB::commit();
                return redirect()->back()->with(notifyMsg('success', 'You changes your password successfully.'));
            } catch(\Exception $e){
                DB::rollBack();
                return redirect()->back()->with(notifyMsg('warning', $e->getMessage()));
            }
        }
    }

    public function get_account_setting() //Delete Or Deactivate Account
    {
        return $this->client_view($this->page.'get_account_setting');
    }

    public function post_account_setting(Request $request) // Delete or Deactivate Account Post 
    {
        $validator = Validator::make($request->all(),[
            'password' => ['required', new MatchOldPassword()],
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if($validator->passes()){
            try{
                DB::beginTransaction();
                $user = User::where('id', Auth::user()->id)->first();
                $user->update(['account_status' => $request->saveType]);
                DB::commit();
                if($request->saveType == 'Deactivated'){
                    $msg = 'Your account has been deactivated.';
                } else {
                    $msg = 'Your account has been deleted.';
                }
                return redirect()->back()->with(notifyMsg('success', $msg));
            } catch(\Exception $e){
                DB::rollBack();
                return redirect()->back()->with(notifyMsg('warning', $e->getMessage()));
            }
        }
    }
}
