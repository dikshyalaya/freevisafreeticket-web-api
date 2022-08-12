<?php

namespace App\Http\Controllers\Candidates;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Traits\Site\ThemeMethods;
use App\Http\Controllers\Controller;
use App\Traits\Site\CandidateMethods;

class SupportController extends Controller
{
    use ThemeMethods, CandidateMethods;

    private $page = 'candidates.setting.support.';

    public function get_support()
    {
        $pages = Page::whereIn('slug', ['terms-and-conditions', 'privacy-policy', 'feedback-and-support'])->get();
        return $this->client_view($this->page.'index',[
            'pages' => $pages,
        ]);
    }
}
