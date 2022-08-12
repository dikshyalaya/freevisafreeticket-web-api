<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\Admin\AdminMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    use AdminMethods;
    private $page = "admin.user.";


    public function users()
    {
        $admins = User::where('user_type', 'admin')->whereHas('admin_profile')->with('admin_profile')->paginate(10);
        return $this->view($this->page.'lists',[
            'admins' => $admins,
        ]);
    }

    public function profile()
    {
        $admin = Auth::user();
        $admin_detail = DB::table("admin_profiles")->where("user_id", $admin->id)->first();
        return $this->view($this->page.'profile', ['admin' => $admin, 'admin_detail'=>$admin_detail]);
    }

    public function updateProfile(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'avatar' => ['nullable', 'mimes:jpeg,jpg,png', 'max:2048'],
            'email' => ['required','email'],
            'name' => ['required'],
        ]);
        $user = Auth::user();
        // dd($user);
        $auth_user = User::where("id", $user->id)->first();
        $admin_profile = DB::table('admin_profiles')->where("user_id", $user->id)->first();
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }
        $oldAvatar = $admin_profile->avatar;
        if($validator->passes()){
            if($request->hasFile('avatar')){
                $avatar = $request->file('avatar');
                $avatarName = time().'_'.$avatar->getClientOriginalName();
                $avatarInpt = 'uploads/admin/'.$avatarName;
                if($oldAvatar != null && file_exists($oldAvatar)){
                    unlink($oldAvatar);
                }
            } else {
                $avatarInpt = $oldAvatar;
            }
            if($request->filled('password')){
                $password = Hash::make($request->password);
            } else {
                $password = $user->password;
            }
            $auth_user->update(['email' => $request->email, 'password' => $password]);
            DB::table('admin_profiles')->where("user_id", $user->id)->update(['name' => $request->name, 'avatar'=>$avatarInpt]);
            if($request->hasFile('avatar')){
                $avatar->move(public_path('uploads/admin/', 'public'), $avatarName);
            }
            
            return response()->json(['msg'=>"Profile updated."]);
        }

    }

    public function delete($id)
    {
        try{
            DB::beginTransaction();
            $user = User::where('id', $id)->with('admin_profile')->firstOrFail();
            $avatar = !blank($user->admin_profile) ? $user->admin_profile->avatar : '';
            $profile_delete = $user->admin_profile->delete();
            $user_delete = $user->delete();
            if($profile_delete && $user_delete){
                if($avatar != null && file_exists($avatar)){
                    unlink($avatar);
                }
            }
            DB::commit();
            return response()->json(['msg' => 'Admin deleted successfully']);
        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['db_error' => $e->getMessage()]);
        }
    }
}
