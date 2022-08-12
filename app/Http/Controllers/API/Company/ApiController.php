<?php

namespace App\Http\Controllers\API\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Traits\Api\ApiMethods;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use ApiMethods;
    public function listing(Request $request)
    {

        $query = Company::query();
        $query->with(['country', 'state', 'city', 'industry'])->where('is_active', 1);

        if ($request->has('search_query') AND !blank($request->search_query)) {
            $filter = $request->search_query;
            $query->where(function ($q) use ($filter) {
                $q->where('company_name', 'LIKE', '%' . $filter . '%');
                $q->orWhere('company_email', 'LIKE', '%' . $filter . '%');
                $q->orWhere('company_details', 'LIKE', '%' . $filter . '%');
            });
        }

        $companies = $query->paginate(20);
        $responseData = $this->sendResponse(compact('companies'), 'success');
        return $responseData;
    }

    public function display($company_id)
    {
        try{
            $company = Company::with(['country', 'state', 'city', 'industry'])->whereId($company_id)->firstOrFail();
            $responseData = $this->sendResponse(compact('company'), 'success');
            return $responseData;
        }catch (\Exception $exception){
            $responseData = $this->sendError($exception->getMessage(),404,'');
            return $responseData;
        }
    }
}
