<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Industry;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\News;
use App\Traits\Site\CandidateMethods;
use App\Traits\Site\CompanyMethods;
use DB;
use Illuminate\Http\Request;
use App\Traits\Site\ThemeMethods;
use Illuminate\Notifications\DatabaseNotification as Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\Employe;

class HomeController extends Controller
{
    use ThemeMethods, CompanyMethods, CandidateMethods;
    public function home()
    {
        $news = News::where('is_active', 1)->orderBy('id', 'desc')->limit(10)->get();
        $companies = Company::where('is_active', 1)->orderBy('id', 'desc')->limit(10)->get();
        $industries = Industry::limit(12)->get();
        $latest_jobs = Job::where('is_active', 1)
            ->with(['company', 'country', 'job_category'])
            ->orderBy('id', 'desc')->limit(10)->get();

        return $this->site_view('site.home',
            compact('news', 'companies', 'latest_jobs', 'industries')
        );
    }
    public function companies(Request $request)
    {
        $companies = Company::with([
            'country',
            'country',
            'state',
            'city',
            'industry',
            'jobs',
        ])->paginate(10);
        $employe = "";
        if(Auth::user()){
            $employe = Employe::where('user_id', Auth::user()->id)->first();
        }
        return $this->site_view('site.companies', ["companies" => $companies,"employe"=>$employe]);
    }
    public function company($id)
    {
        $company = Company::findOrFail($id);
        $company_jobs = Job::where("company_id", $id)->with(['country', 'company', 'job_category'])->paginate(10);
        $employe = "";
        if(Auth::user()){
            $employe = Employe::where('user_id', Auth::user()->id)->first();
        }
        return $this->site_view('site.company-view', ['company' => $company, "company_jobs" => $company_jobs,"employe"=>$employe]);
    }



    public function getJobsByTitle(Request $request)
    {
        $jobs = Job::where('title', 'LIKE', '%'.$request->job_title.'%')->get();
        return $jobs;
    }


    public function markRead(Request $request)
    {
        $notification = Notification::find($request->id);
        $notification->markAsRead();
        if($notification->data['link'] != ''){
            return redirect($notification->data['link']);
        }
    }


    public function readNotifications($type, $notification_id)
    {
        $user = \Auth::user();
        if ($type == 'single'){
            $notification = $user->notifications()->where('id',$notification_id)->first();
            $notification->markAsRead();
        }elseif($type == 'unread'){
            $user->unreadNotifications->markAsRead();
        }

        return redirect()->back();
    }
}
