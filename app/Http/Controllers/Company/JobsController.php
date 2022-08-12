<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Site\CompanyMethods;
use App\Models\Job;

class JobsController extends Controller
{
    use CompanyMethods;
    public function index(Request $request)
    {
        $query = Job::where('company_id', $this->company()->id);
        $this->__query_jobs($query, $request);
        $jobs = $query->paginate(10);
        $sn = ($jobs->perPage() * ($jobs->currentPage() - 1)) + 1;
        return $this->site_view('company.jobs', [
            'jobs' => $jobs,
            "pagination" => $jobs->appends(array(
                'type' => $request->type,
                'search' => $request->term,
            )),
            // 'all_jobs' => $jobs->paginate(10),
            // 'active_jobs' => $jobs->where('is_active', 1)->paginate(10),
            // 'inactive_jobs' => $jobs->where('is_active', 0)->paginate(10),
            "company" => $this->company(),
            'sn' => $sn,
        ]);
    }

//    public function index(Request $request)
//    {
//        $query = Job::where('company_id', $this->company()->id);
//        $this->__query_jobs($query, $request);
////        $jobs = $query->paginate(10);
//        $jobs = $query->get();
////        $sn = ($jobs->perPage() * ($jobs->currentPage() - 1)) + 1;
//        return $this->site_view('company.jobs', [
//            'jobs' => $jobs,
////            "pagination" => $jobs->appends(array(
////                'type' => $request->type,
////                'search' => $request->term,
////            )),
//            // 'all_jobs' => $jobs->paginate(10),
//            // 'active_jobs' => $jobs->where('is_active', 1)->paginate(10),
//            // 'inactive_jobs' => $jobs->where('is_active', 0)->paginate(10),
//            "company" => $this->company(),
////            'sn' => $sn,
//        ]);
//    }

    private function __query_jobs($query, $request)
    {
        $query->when($request->type == 'all', function ($q) {
            $q;
        })->when($request->type == 'draft_jobs', function ($q) {
            $q->where('status', 'Draft');
        })->when($request->type == 'pending_jobs', function ($q) {
            $q->where('status', 'Pending');
        })->when($request->type == 'published_jobs', function ($q) {
            $q->where('status', 'Published');
        })->when($request->type == 'expired_jobs', function ($q) use ($request) {
            $q->where('status', 'Expired');
        })->when($request->type == 'rejected_jobs', function ($q) use ($request) {
            $q->where('status', 'Rejected');
        })->when($request->has('term'), function ($q) use ($request) {
            $q->where('title', 'LIKE', '%' . $request->term . '%');
        });
    }
}
