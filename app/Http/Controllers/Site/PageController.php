<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Site\ThemeMethods;
use DB;

class PageController extends Controller
{
    use ThemeMethods;
    public function index($slug)
    {
        $page = DB::table('pages')->where('slug', $slug)->first();
        if (!$page) {
            return abort('404');
        } else {
            $fields = [
                "page" => $page
            ];
            return $this->site_view("site.page", $fields);
        }
    }
}
