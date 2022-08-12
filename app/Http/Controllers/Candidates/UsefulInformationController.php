<?php

namespace App\Http\Controllers\Candidates;

use App\Http\Controllers\Controller;
use App\Models\UsefulInformation;
use App\Traits\Site\CandidateMethods;
use App\Traits\Site\ThemeMethods;
use Illuminate\Http\Request;

class UsefulInformationController extends Controller
{
    use ThemeMethods, CandidateMethods;

    private $page = 'candidates.usefulinfo.';

    public function index()
    {
        return $this->client_view($this->page.'index', [
            'informations' => UsefulInformation::get(),
        ]);
    }

    public function detail($slug)
    {
        $information = UsefulInformation::where('slug', $slug)->firstOrFail();
        if($information){
            $other_information = UsefulInformation::where('id', '!=', $information->id)->orderBy('id', 'desc')->take(10)->get();
        } else {
            $other_information = UsefulInformation::orderBy('id', 'desc')->take(10)->get();
        }
        return $this->client_view($this->page.'detail', [
            'information' => $information,
            'other_information' => $other_information,
        ]);
    }
}
