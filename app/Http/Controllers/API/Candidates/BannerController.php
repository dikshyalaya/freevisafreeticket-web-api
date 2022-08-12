<?php

namespace App\Http\Controllers\API\Candidates;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Api\ApiMethods;
use DB;
class BannerController extends Controller
{
    use ApiMethods;
    public function list(){
        $results=[];
        $banners=DB::table('banners')->where("is_active",true)->get();
        foreach($banners as $index=>$banner){
            $results[$index]=$this->process($banner);
        }
        return $this->sendResponse($results,"News List.");
    }
    public function process($banner){
        return [
            "sort_order"=>$banner->sort_order,
            "url"=>env('APP_URL').$banner->url
        ];
    }
}
