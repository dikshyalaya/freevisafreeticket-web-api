<?php

namespace App\Traits\Site;
use App\Models\Country;
use App\Models\Industry;
use App\Models\JobCategory;
use App\Models\MenuItem;
use Illuminate\Http\Response;
use DB;
trait ThemeMethods{
    public function site_view($path,$obj=[]){
        $theme="fvft";
        $primary_menu = MenuItem::where(["menu_id"=>1,"parent_id"=>0])->get();
        $countries = Country::where('is_active', 1)->get();
        $job_categories = JobCategory::has('jobs')->get();
        $all_job_categories = JobCategory::all();
        $job_industries = Industry::get();

        return view("themes.".$theme.".".$path,array_merge($obj,[
            'countries'=>$countries,
            'primary_menu'=>$primary_menu,
            'job_categories'=>$job_categories,
            'all_job_categories'=>$all_job_categories,
            'job_industries'=>$job_industries
        ]));
    }
}
