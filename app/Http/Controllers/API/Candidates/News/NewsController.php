<?php

namespace App\Http\Controllers\API\Candidates\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Api\ApiMethods;
use DB;
use App\Http\Controllers\API\Candidates\News\NewsCategoryController;

class NewsController extends Controller
{
    use ApiMethods;
    public function __construct()
    {
        $this->news_category_controller = new NewsCategoryController();
    }
    public function index($id)
    {
        $news = DB::table('news')->find($id);
        return $this->sendResponse($this->process($news), "News Fetched.");
    }
    public function list(Request $request)
    {
        $results = [];

        $news = DB::table('news')->orderBy('id', 'DESC')->get();
        if ($request->has('category_id')) {
            $news = DB::select("SELECT n.id,n.title,n.short_description,n.body,n.feature_img,n.seo_title,n.seo_description,n.seo_keywords,n.slug,n.created_at,n.updated_at FROM manage_news_categories AS mnc INNER JOIN news AS n ON n.id=mnc.news_id WHERE mnc.category_id=?  ORDER BY n.id DESC", [$request->category_id]);
        }
        foreach ($news as $index => $item) {
            $results[$index] = $this->process($item);
        }
        return $this->sendResponse($results, "News List.");
    }
    public function process($news)
    {
        $categories_processed = [];
        $categories = DB::select("SELECT nc.id, nc.title FROM `manage_news_categories` AS mnc INNER JOIN news_categories AS nc ON nc.id=mnc.category_id WHERE `news_id` =?", [$news->id]);
        foreach ($categories as $index => $category) {
            $categories_processed[$index] = [
                "id" => (int)$category->id,
                "title" => $category->title
            ];
        }
        $posted_by = [
            "name" => "FreeVisFreeTicket",
            "profile_url" => "/uploads/site/logo.png"
        ];
        return [
            "id" => (int)$news->id,
            "title" => $news->title,
            "body" => htmlspecialchars_decode($news->html_content),
            "feature_img" => $news->feature_img,
            "categories" => $categories_processed,
            "posted_by" => $posted_by,
            "created_at" => $news->created_at,
            "updated_at" => $news->updated_at
        ];
    }
}
