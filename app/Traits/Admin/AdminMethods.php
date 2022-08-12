<?php
 
namespace App\Traits\Admin;
use Illuminate\Http\Response;
use DB;
trait AdminMethods{
    public function view($path,$obj=[]){
        $user= \Auth::user();
        $admin= DB::table('admin_profiles')->where('user_id',$user->id)->first();
        $user=[
            "user_id"=>$user->id,
            "user_email"=>$user->email,
            "admin_id"=>$admin->id,
            "name"=>$admin->name,
            "profile"=>$admin->avatar,
            "cover"=>$admin->cover
        ];
        return view($path,array_merge($obj,[
            'user'=>$user
        ]));
    }
}