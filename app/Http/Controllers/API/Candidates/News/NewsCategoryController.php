<?php

namespace App\Http\Controllers\API\Candidates\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Traits\Api\ApiMethods;
class NewsCategoryController extends Controller
{
    use ApiMethods;

    public function list(){
        $results=[];
        $categories= DB::table('news_categories')->get();
        foreach($categories as $index=>$category){
            $results[$index]=$this->process($category);
        }
        return $this->sendResponse($results,"News Category List.");
    }
    public function process($category){
        return [
            "id" => $category->id,
            "title" => $category->title,
        ];
    }
}
