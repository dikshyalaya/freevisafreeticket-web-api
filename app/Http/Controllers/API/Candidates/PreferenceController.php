<?php

namespace App\Http\Controllers\API\Candidates;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Employe;
use App\Models\EmployesCountry;
use App\Models\EmployesJobCategory;
use App\Models\Industry;
use App\Models\JobCategory;
use App\Traits\Api\ApiMethods;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PreferenceController extends Controller
{
    use ApiMethods;

    // with polymorphic relation
    public function getJobPreference()
    {
        $user = auth()->guard('api')->user();
        $employee = Employe::where('user_id', $user->id)->first();

        $preferred_countries = $employee->countryPreference;
        $preferred_industries = $employee->industryPreference;
        $preferred_categories = $employee->jobCategoryPreference;

        return $this->sendResponse(compact('preferred_categories','preferred_countries','preferred_industries'), 'Preference saved successfully.');
    }

    public function saveJobPreference(Request $request)
    {
        $user = auth()->guard('api')->user();
        $employee = Employe::where('user_id', $user->id)->first();

        $country_id = $request->country_id ?? null;
        $industry_id = $request->industry_id ?? null;
        $category_id = $request->job_category_id ?? null;

        if (!blank($country_id)){

            if (count($employee->countryPreference) > 2){
                return $this->sendResponse([], 'Country limit reached in job preference', '', false);
            }

            $country = Country::find($country_id);
            $employee->countryPreference()->attach($country);
        }

        if (!blank($industry_id)){

            if (count($employee->industryPreference) > 2){
                return $this->sendResponse([], 'Industry limit reached in job preference', '', false);
            }

            $industry = Industry::find($industry_id);
            $employee->industryPreference()->attach($industry);
        }

        if (!blank($category_id)){

            if (count($employee->jobCategoryPreference) > 2){
                return $this->sendResponse([], 'Category limit reached in job preference', '', false);
            }

            $job_category = JobCategory::find($category_id);
            $employee->jobCategoryPreference()->attach($job_category);
        }
        return $this->sendResponse([], 'Preference saved successfully.');
    }

    public function removeJobPreference(Request $request)
    {
        $user = auth()->guard('api')->user();
        $employee = Employe::where('user_id', $user->id)->first();

        $country_id = $request->country_id ?? null;
        $industry_id = $request->industry_id ?? null;
        $category_id = $request->job_category_id ?? null;

        if (!blank($country_id)){
            $country = Country::find($country_id);
            $employee->countryPreference()->detach($country);
        }

        if (!blank($industry_id)){
            $industry = Industry::find($industry_id);
            $employee->industryPreference()->detach($industry);
        }

        if (!blank($category_id)){
            $job_category = JobCategory::find($category_id);
            $employee->jobCategoryPreference()->detach($job_category);
        }

        return $this->sendResponse([], 'Preference removed successfully.');
    }
    // with polymorphic relation end

    // Get employes job category
    public function get_employes_job_category()
    {
        try {
            $employ = Employe::where('user_id', auth()->user()->id)->first();
            $employes_job_category = EmployesJobCategory::where('employ_id', $employ->id)
                ->orderBy('order_by', 'asc')
                ->get();
            if ($employes_job_category->count() > 0) {
                $records = [];
                foreach ($employes_job_category as $key => $value) {
                    $records[] = $this->process_employees_job_category($value);
                }
                return $this->sendResponse($records, 'Employes job category fetched successfully.');
            } else {
                return $this->sendError('No job category preference found', 200);
            }
        } catch (\Throwable$th) {
            return $this->sendError("Error fetching preference. ");
        }
    }
    public function add_employes_job_category(Request $request)
    {
        try {
            $employ = Employe::where('user_id', auth()->user()->id)->first();

            $request->validate([
                'job_category_id' => [
                    'required',
                    'integer',
                    'exists:countries,id',
                    Rule::unique('employes_job_categories', 'job_category_id')->where(function ($query) use ($employ) {
                        return $query->where('employ_id', $employ->id);
                    }),
                ],
            ]);
            $old = EmployesJobCategory::where('employ_id', $employ->id)
                ->orderBy('order_by', 'desc')
                ->first();

            $employes_job_category = new EmployesJobCategory;
            $employes_job_category->employ_id = $employ->id;
            $employes_job_category->job_category_id = $request->job_category_id;
            $employes_job_category->order_by = $old ? $old->order_by + 1 : 1;
            $employes_job_category->save();
            return $this->sendResponse($this->process_employees_job_category($employes_job_category), 'Job category preference added successfully');
        } catch (\Throwable$th) {
            return $this->sendError("Unable to add preference.", 200);
        }
    }
    // update_employes_job_category
    public function update_employes_job_category(Request $request)
    {
        try {
            $preferences = $request->all();
            $employ = Employe::where('user_id', auth()->user()->id)->first();
            foreach ($preferences as $key => $value) {
                $employes_job_category = EmployesJobCategory::where('employ_id', $employ->id)
                    ->where("id", $value['id'])
                    ->first();
                $employes_job_category->job_category_id = $value['job_category_id'];
                $employes_job_category->order_by = $value['order_by'];
                $employes_job_category->save();
            }
            $employes_job_category = EmployesJobCategory::where('employ_id', $employ->id)
                ->orderBy('order_by', 'asc')->get();
            if ($employes_job_category->count() > 0) {
                $records = [];
                foreach ($employes_job_category as $key => $value) {
                    $records[] = $this->process_employees_job_category($value);
                }
                return $this->sendResponse($records, 'Job category preference updated successfully.');
            } else {
                return $this->sendError('No job category preference found', 200);
            }
        } catch (\Throwable$th) {
            return $this->sendError("Unable to update preference.", 200);
        }
    }
    // delete_employes_job_category
    public function delete_employes_job_category($id)
    {
        try {
            $request = new Request();
            $request->replace(['id' => $id]);
            $employ = Employe::where('user_id', auth()->user()->id)->first();
            $request->validate([
                'id' => [
                    'required',
                    'integer',
                    'exists:employes_job_categories,id',
                    Rule::exists('employes_job_categories', 'id')->where(function ($query) use ($employ) {
                        return $query->where('employ_id', $employ->id);
                    }),
                ],
            ]);
            $employes_job_category = EmployesJobCategory::where('employ_id', $employ->id)
                ->where("id", $id)
                ->first();

            $employes_job_category->delete();
            return $this->sendResponse(
                [],
                "Preference deleted successfully."
            );
        } catch (\Throwable$th) {
            return $this->sendError("Unable to delete preference.");
        }
    }
    // Get employes country
    public function get_employes_country()
    {
        try {
            $employ = Employe::where('user_id', auth()->user()->id)->first();
            $employes_country = EmployesCountry::where('employ_id', $employ->id)
                ->orderBy('order_by', 'asc')
                ->get();
            if ($employes_country->count() > 0) {
                $records = [];
                foreach ($employes_country as $key => $value) {
                    $records[] = $this->process_employees_country($value);
                }
                return $this->sendResponse($records, 'Employes country fetched successfully.');
            } else {
                return $this->sendError('No country preference found', 200);
            }
        } catch (\Throwable$th) {
            return $this->sendError("Error fetching preference. ");
        }
    }
    public function add_employes_country(Request $request)
    {
        try {
            $employ = Employe::where('user_id', auth()->user()->id)->first();
            // Validate order by and country id unique for this employ
            $old = EmployesCountry::where('employ_id', $employ->id)
                ->orderBy('order_by', 'desc')
                ->first();
            $request->validate([
                'country_id' => [
                    'required',
                    'integer',
                    'exists:countries,id',
                    Rule::unique('employes_country', 'country_id')->where(function ($query) use ($employ) {
                        return $query->where('employ_id', $employ->id);
                    }),
                ],
            ]);

            $employes_country = new EmployesCountry;
            $employes_country->employ_id = $employ->id;
            $employes_country->country_id = $request->country_id;
            $employes_country->order_by = $old ? (int) $old->order_by + 1 : 1;
            $employes_country->save();
            return $this->sendResponse($this->process_employees_country($employes_country), 'Country preference added successfully');
        } catch (\Throwable$th) {
            return $this->sendError("Unable to add preference." . $th->getMessage(), 200);
        }
    }
    public function update_employes_country(Request $request)
    {
        try {
            $employ = Employe::where('user_id', auth()->user()->id)->first();
            $preferences = $request->all();
            foreach ($preferences as $key => $preference) {
                $employes_country = EmployesCountry::where('employ_id', $employ->id)
                    ->where("id", $preference['id'])
                    ->first();
                if ($employes_country != null) {
                    $employes_country->country_id = $preference['country_id'];
                    $employes_country->order_by = $preference['order_by'];
                    $employes_country->save();
                }
            }
            $employes_country = EmployesCountry::where('employ_id', $employ->id)
                ->orderBy('order_by', 'asc')->get();
            if ($employes_country->count() > 0) {
                $records = [];
                foreach ($employes_country as $key => $value) {
                    $records[] = $this->process_employees_country($value);
                }
                return $this->sendResponse($records, 'Preference updated successfully.');
            } else {
                return $this->sendError('No country preference found', 200);
            }
        } catch (\Throwable$th) {
            return $this->sendError("Unable to update preference.", 200);
        }
    }
    public function delete_employes_country($id)
    {

        try {
            $request = new Request();
            // add id to request
            $request->merge(['id' => $id]);
            $employ = Employe::where('user_id', auth()->user()->id)->first();
            $request->validate([
                'id' => [
                    'required',
                    'integer',
                    Rule::exists('employes_country', 'id')->where(function ($query) use ($employ) {
                        return $query->where('employ_id', $employ->id);
                    }),
                ],
            ]);
            $employes_country = EmployesCountry::where('employ_id', $employ->id)
                ->where("id", $id)
                ->first();

            $employes_country->delete();
            return $this->sendResponse(
                [],
                "Preference deleted successfully."
            );
        } catch (\Throwable$th) {
            return $this->sendError("Unable to delete preference.", 200);
        }
    }
    public function process($employes_country, $employes_job_category)
    {
        $employ = Employe::where('user_id', auth()->user()->id)->first();

        return [
            "employes_country" => [
                "id" => $employes_country->id,
                // "employ_id" => $employes_country->employ_id,
                "country_id" => $employes_country->country_id,
                "order_by" => $employes_country->order_by,
            ],
            "employes_job_category" => [
                "id" => $employes_job_category->id,
                "employ_id" => $employes_job_category->employ_id,
                "job_category_id" => $employes_job_category->job_category_id,
                "order_by" => $employes_job_category->order_by,
            ],
        ];
    }
    public function process_employees_country($employes_country)
    {
        return [
            "id" => (int) $employes_country->id,
            // "employ_id" => $employes_country->employ_id,
            "country_id" => (int) $employes_country->country_id,
            "order_by" => (int) $employes_country->order_by,
        ];
    }
    public function process_employees_job_category($employes_job_category)
    {
        return [
            "id" => (int) $employes_job_category->id,
            // "employ_id" => $employes_job_category->employ_id,
            "job_category_id" => (int) $employes_job_category->job_category_id,
            "order_by" => (int) $employes_job_category->order_by,
        ];
    }
}
