<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\UsefulInformation;
use App\Traits\Api\ApiMethods;


class UsefulInformationController extends Controller
{
    use ApiMethods;

    public function GetPage(Request $request){
        $slug = $request->slug;

        $data=[];

        if($slug==""){
            $data = UsefulInformation::where("is_active",1)->get();

            $data->transform(function ($value) {
                return [
    
                    'title' => $value->title,
                    'slug' => $value->slug,
                    'banner' => $value->logo,
    
                ];
            });
    
        }else{
            $data = UsefulInformation::where(["slug"=>$slug, "is_active"=>1])->get();  
        }
            
        
        return $this->sendResponse($data,"success");
        //return $page;
    }
}
