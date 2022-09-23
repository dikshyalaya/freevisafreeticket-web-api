<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\UsefulInformation;

class UsefulInformationController extends Controller
{
    public function List(Request $request)
    {

        $useful_info = UsefulInformation::where("is_active",1)->get();

        $useful_info->transform(function ($value) {
            return [

                'title' => $value->title,
                'slug' => $value->slug,
                'banner' => $value->logo,

            ];
        });

        return $useful_info;
    }

    public function GetPage(Request $request){
        $slug = $request->slug;
        $page = UsefulInformation::where(["slug"=>$slug, "is_active"=>1])->get();
        return $page;
    }
}
