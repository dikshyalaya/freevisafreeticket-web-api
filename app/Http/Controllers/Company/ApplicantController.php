<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Employe;
use App\Models\JobApplication;
use App\Traits\Site\CompanyMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplicantController extends Controller
{
    use CompanyMethods;

    public function __construct()
    {
        $GLOBALS['page-name'] = "Applicant";
    }

    public function applicants(Request $request)
    {
        if ($request->filled('job_title')) {
            $applicants = JobApplication::whereHas('job', function ($query) use ($request) {
                return $query->where('title', 'LIKE', '%' . $request->job_title . '%')
                    ->whereHas('company', function ($query2) {
                        return $query2->where('user_id', Auth::user()->id)->with(['employe', 'job']);
                    });
                //     return $query2->whereHas('company', function($query3){
                //         return $query3->where('user_id', Auth::user()->id)->with(['employe', 'job']);
                //     });
                // });
            })->paginate(10)->setPath('');

        } else if ($request->filled('category_id')) {
            $applicants = JobApplication::whereHas('job', function ($query) use ($request) {
                return $query->where('job_categories_id', $request->category_id)
                    ->whereHas('company', function ($query2) {
                        return $query2->where('user_id', Auth::user()->id)->with(['employe', 'job']);
                    });
            })->paginate(10)->setPath('');
        } else if ($request->filled('job_title') && $request->filled('category_id')) {
            $applicants = JobApplication::whereHas('job', function ($query) use ($request) {
                return $query->where('title', 'LIKE', '%' . $request->job_title . '%')
                    ->orWhere('job_categories_id', $request->category_id)
                    ->whereHas('company', function ($query2) {
                        return $query2->where('user_id', Auth::user()->id)->with(['employe', 'job']);
                    });
            })->paginate(10)->setPath('');
        } else {
            $applicants = JobApplication::whereHas('job', function ($query) {
                return $query->whereHas('company', function ($query2) {
                    return $query2->where('user_id', Auth::user()->id)->with(['employe', 'job']);
                });
            })->paginate(10)->setPath('');
        }

        return $this->company_view('company.applicant.index',
            [
                'pagination' => $applicants->appends(array(
                    'job_title' => $request->job_title,
                )),
                'applicants' => $applicants,
                'categories' => DB::table('job_categories')->get(),
            ]);
    }

    public function edit_application($id)
    {
        $application = JobApplication::where('id', $id)->with(['employe'])->firstOrFail();
        $GLOBALS['this_action'] = 'Edit Application';
        return $this->company_view('company.applicant.edit', ['application' => $application]);
    }

    public function updateApplication(Request $request, $id)
    {
        try {
            $application = JobApplication::find($id);
            $input = $request->except('_token');
            $input['status'] = $request->status;
            $input['interview_status'] = $request->interview_status;
            $input['interview_data'] = $request->interview_date;
            $input['interview_time'] = $request->interview_time;
            $application->update($input);
            return response()->json(['msg' => 'Application detail updated successfullu', 'redirectRoute' => route('company.applicant.index')]);
        } catch (\Exception$e) {
            return response()->json(['db_error' => $e->getMessage()]);
        }
    }

    public function applicant_detail($id)
    {
        $employ = Employe::where('id', $id)->with(['user'])->firstOrFail();
        return $this->company_view('company.applicant.detail', ['employ' => $employ]);
    }
}
