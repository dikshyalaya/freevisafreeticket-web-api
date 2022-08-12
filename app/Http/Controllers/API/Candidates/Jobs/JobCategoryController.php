<?php

namespace App\Http\Controllers\API\Candidates\Jobs;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use App\Traits\Api\ApiMethods;
use DB;
class JobCategoryController extends Controller
{
    use ApiMethods;
    public function index(Request $request){
        $job_category= DB::table('job_categories')->
        find($request->job_categoriy_id);
        return $this->sendResponse($this->process($job_category),"Jobs Category List.");
    }

    public function categoryListing(Request $request)
    {
        $limit= $request->has("limit") ? $request->limit : 10;
        $query = JobCategory::query();
        $query->has('jobs')->where('is_active', 1);

        if($request->has("search_query")) {
            $searchTerm = $request->search_query;
            $query->where('functional_area', 'LIKE', "%{$searchTerm}%");
        }

        $job_categories = $query->paginate($limit);
        $job_categories->setCollection(
            $job_categories->getCollection()->transform(function ($value) {
                return [
                    'id' => $value->id,
                    'category' => $value->functional_area,
                    'image_url' => $value->image_url,
                    'sort_order' => $value->sort_order,
                    'jobsCount' => $value->jobsCount()
                ];
            })
        );

        return $this->sendResponse(compact('job_categories'),"success");
    }

//    public function list(Request $request){
//        $results=[];
//        $limit= $request->has("limit")?$request->limit:10;
//        $job_categorys= DB::table('job_categories');
//        $total_records=$job_categorys->count();
//        if($request->has("page_no")){
//            $job_categorys->limit($limit)->offset($request->page_no>=1?($request->page_no-1)*$limit:1);
//        }else{
//            $job_categorys->limit($limit);
//        }
//        foreach($job_categorys->get() as $index=>$category){
//            $results[$index]=$this->process($category);
//        }
//        $total_page_no=(int)($total_records/$limit);
//        $page_no=$request->has("page_no")?$request->page_no:1;
//        $pagination=[
//            "total_records"=>$total_records,
//            "total_pages"=>$total_page_no,
//            "limit"=>$limit,
//            "page_no"=>$page_no,
//        ];
//        $page_no>1?
//        $pagination=array_merge(
//        $pagination,
//        ["previous"=>$page_no-1]
//        ):null;
//        $page_no<$total_page_no?
//        $pagination=array_merge(
//        $pagination,
//        ["next"=>$page_no+1]
//        ):null;
//
//        return $this->sendResponse($results,"Jobs Category List.",$pagination);
//    }

    public function process($category){
        return [
            "id" => (int)$category->id,
            "category" => $category->functional_area,
            "image_url" => $category->image_url,
            "sort_order"=>(int)$category->sort_order
        ];
    }
}
