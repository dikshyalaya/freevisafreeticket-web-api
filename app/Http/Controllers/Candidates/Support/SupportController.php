<?php

namespace App\Http\Controllers\Candidates\Support;

use App\Http\Controllers\Controller;
use App\Models\Support;
use App\Models\SupportCategory;
use App\Traits\Site\CandidateMethods;
use App\Traits\Site\ThemeMethods;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    use ThemeMethods, CandidateMethods;

    private $page = "candidates.support.";

    private $redirectTo = 'candidate.support.support';

    public function index()
    {
        return $this->client_view($this->page.'index', [
            'support_categories' => SupportCategory::whereHas('supports')->get(),
        ]);
    }

    public function get_support_questions($slug)
    {
        $support_category = SupportCategory::where('slug', $slug)->firstOrFail();
        $supports = Support::where('support_category_id', $support_category->id)->whereHas('support_types', function($query){
            $query->where('title', 'Employ');
        })->get();
        return $this->client_view($this->page.'support_questions',[
            'supports' => $supports,
            'support_category' => $support_category,
        ]);
    }

    public function get_question_answer($slug)
    {
        $support = Support::where('slug', $slug)->with('support_category:id,title')->firstOrFail();
        $other_supports = null;
        if($support){
            $other_supports = Support::where('support_category_id', $support->support_category_id)->where('id', '!=', $support->id)->whereHas('support_types', function($query){
                $query->where('title', 'Employ');
            })->get();
        }
        return $this->client_view($this->page."support_answer",[
            'support' => $support,
            'other_supports' => $other_supports
        ]);
    }
}
