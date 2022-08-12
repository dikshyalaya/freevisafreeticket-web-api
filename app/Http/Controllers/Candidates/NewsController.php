<?php

namespace App\Http\Controllers\Candidates;

use App\Models\News;
use Illuminate\Http\Request;
use App\Traits\Site\ThemeMethods;
use App\Http\Controllers\Controller;
use App\Traits\Site\CandidateMethods;

class NewsController extends Controller
{
    use ThemeMethods, CandidateMethods;
    
    private $page = 'candidates.news.';

    public function index()
    {
        return $this->client_view($this->page.'index', [
            'news' => News::orderBy('id', 'desc')->paginate(6),
        ]);
    }

    public function newsdetail($slug)
    {
        $news = News::where('slug', $slug)->firstOrFail();
        if($news){
            $other_news = News::where('id', '!=', $news->id)->orderBy('id', 'desc')->take(10)->get();
        } else {
            $other_news = News::orderBy('id', 'desc')->take(10)->get();
        }
        return $this->client_view($this->page.'detail',[
            'news' => $news,
            'other_news' => $other_news,
        ]);
    }
}
