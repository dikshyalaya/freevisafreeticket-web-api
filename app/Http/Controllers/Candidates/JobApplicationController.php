<?php

namespace App\Http\Controllers\Candidates;

use Illuminate\Http\Request;
use App\Traits\Site\ThemeMethods;
use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Traits\Site\CandidateMethods;

class JobApplicationController extends Controller
{
    use ThemeMethods, CandidateMethods;
    private $page = 'candidates.job_application.';

    public function __construct()
    {

    }

    public function index(Request $request, $type = null)
    {
        $datas = $this->__datas();
        $applications = JobApplication::where('employ_id', $this->employe()->id)->with(['job:id,title,company_id,country_id', 'job.company:id,company_name', 'job.country:id,name']);
        $applications = $this->__query_applications($applications, $type);
        $applications = $applications->paginate(10);
        return $this->client_view($this->page.'index',[
            'datas' => $datas, 
            'applications' => $applications,
            'action' => $this->__actions($type),
        ]);
    }

    private function __query_applications($query, $type)
    {
        return $query->when(($type == '' || $type == 'all-applicants'), function($q){
            $q;
        })->when($type == 'unscreened-applications', function($q){
            $q->where('status', 'pending');
        })->when($type == 'shortlisted-applications', function($q){
            $q->where('status', 'shortlisted');
        })->when($type == 'interviewed-applications',function($q){
            $q->where('status', 'interviewed');
        })->when($type == 'selected-applications', function($q){
            $q->where('status', 'accepted');
        })->when($type == 'rejected-applications', function($q){
            $q->where('status', 'rejected');
        });
    }

    private function __route($type)
    {
        return route('candidate.job_application.index', $type);
    }

    private function __datas()
    {
        return  [
            [
                'title' => 'All Applications',
                'link' => $this->__route('all-applications'),
                'totalcount' => $this->employe()->job_applications->count(),
                'image' => 'mail.svg',
                'bg-color' => 'bg-blue',
            ],
            [
                'title' => 'Unscreened Applications',
                'link' => $this->__route('unscreened-applications'),
                'totalcount' => $this->employe()->job_applications->where('status', 'pending')->count(),
                'image' => 'megaphone.svg',
                'bg-color' => 'bg-gray',
            ],
            [
                'title' => 'Shortlisted Applications',
                'link' => $this->__route('shortlisted-applications'),
                'totalcount' => $this->employe()->job_applications->where('status', 'shortlisted')->count(),
                'image' => 'blogging.svg',
                'bg-color' => 'bg-pink',
            ],
            [
                'title' => 'Interviewed Applications',
                'link' => $this->__route('interviewed-applications'),
                'totalcount' => $this->employe()->job_applications->where('status', 'selectedForInterview')->count(),
                'image' => 'picture.svg',
                'bg-color' => 'bg-orange',
            ],
            [
                'title' => 'Selected Applications',
                'link' => $this->__route('selected-applications'),
                'totalcount' => $this->employe()->job_applications->where('status', 'accepted')->count(),
                'image' => 'picture.svg',
                'bg-color' => 'bg-green',
            ],
            [
                'title' => 'Rejected Applications',
                'link' => $this->__route('rejected-applications'),
                'totalcount' => $this->employe()->job_applications->where('status', 'rejected')->count(),
                'image' => 'box-closed.svg',
                'bg-color' => 'bg-red',
            ],
        ];
    }


    private function __actions($type)
    {
        switch ($type) {
            case 'all-applications':
                return 'All Applications';
                break;
            case 'unscreened-applications':
                return 'Unscreened Applications';
                break;
            case 'shortlisted-applications':
                return 'Shortilisted Applications';
                break;
            case 'interviewed-applications':
                return 'Interviewed Applications';
                break;
            case 'selected-applications':
                return 'Selected Applications';
                break;
            case 'rejected-applications':
                return 'Rejected Applications';
                break;
            default:
                return 'All Applications';
        }
    }
}
