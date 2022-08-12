<?php

namespace App\Http\Controllers\API\Location;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use App\Traits\Api\ApiMethods;
use DB;

class LocationV2Controller extends Controller
{
    use ApiMethods;


    public function countries(Request $request)
    {
        $limit = $request->has("limit") ? $request->limit : 10;
        $query = Country::query();
        $query->where('is_active', 1);

        if ($request->has("search_query")) {
            $searchTerm = $request->search_query;
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        $countries = $query->paginate($limit);
        return $countries;
    }

}
