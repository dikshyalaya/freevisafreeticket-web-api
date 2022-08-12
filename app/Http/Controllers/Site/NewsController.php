<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Traits\Site\ThemeMethods;

class NewsController extends Controller
{
    use ThemeMethods;
    public function index(Request $request)
    {
        $fields = [];
        $news = DB::table('news');
        $news_categories = DB::table('news_categories')->get();
        $request->has('search') ? $news->where('title', 'like', '%' . $request->search . '%') : null;
        // $request->has('category') ? $news->where('category_id', $request->category) : null;
        if ($request->has('category')) {
            $news->select('news.id', 'news.title', 'news.short_description', 'news.body', 'news.feature_img', 'news.seo_title', 'news.seo_description', 'news.seo_keywords', 'news.slug', 'news.created_at', 'news.updated_at')
                ->join('manage_news_categories as mnc', 'news.id', '=', 'mnc.news_id')
                ->where('mnc.category_id', $request->category)
                ->orderBy('news.id', 'DESC');
        }
        $fields = [
            "news" => $news->paginate(9),
            "news_categories" => $news_categories
        ];

        return $this->site_view("site.news", $fields);
    }
    public function getNews($slug)
    {
        $news = DB::table('news')->where('slug', $slug)->first();
        $news_categories = DB::table('news_categories')->get();
        $fields = [
            "news" => $news,
            "news_categories" => $news_categories
        ];
        return $this->site_view("site.news_view", $fields);
    }
}
