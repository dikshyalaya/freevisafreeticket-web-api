<?php

namespace App\Http\Controllers\API\Location;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use App\Traits\Api\ApiMethods;
use DB;

class LocationController extends Controller
{
    use ApiMethods;

    public function countries(Request $request)
    {
        $limit= $request->has("limit") ? $request->limit : 10;
        $query = Country::query();
        $query->where('is_active', 1);

        if($request->has("search_query")) {
            $searchTerm = $request->search_query;
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        $countries = $query->paginate($limit);

        $countries->transform(function ($value) {
            return [
                'id' => $value->id,
                'name' => $value->name,
                //'capital' => $value->capital,
                'native' => $value->native,
                'country_code' => $value->iso3,
                'phonecode' => $value->phonecode,
                'flag' => "/assets/images/flags/" . strtolower($value->iso2) . ".svg",
                //'region' => $value->regions,
               // 'subregion' => $value->subregion,
               // 'timezones' => json_decode($value->timezones),

                'curreny' => $value->currency,
                'currency_name' => $value->currency_name,
                'currency_symbol' => $value->currency_symbol,
                //'translations' => json_decode($value->translations)

                // 'state' => $value->states,
                // 'cities' => $value->cities,
                // 'districts' => $value->districts,
            ];
        });

        return $this->sendResponse(compact('countries'),"success");
    }

    public function states(Request $request)
    {
        $limit= $request->has("limit") ? $request->limit : 10;

        $country_id = $request->country_id;

        $query = State::query()->where('country_id', $country_id);

        if($request->has("search_query")) {
            $searchTerm = $request->search_query;
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

      
        $states = $query->paginate($limit);

        $states->setCollection(
            $states->getCollection()->transform(function ($value) {
                return [
                    'id' => $value->id,
                    'name' => $value->name
                ];
            })
        );

        return $this->sendResponse(compact('states'),"success");
    }

    public function cities(Request $request)
    {
        $limit= $request->has("limit") ? $request->limit : 10;
        $query = City::query()->where('state_id', $request->state_id);

        if($request->has("search_query")) {
            $searchTerm = $request->search_query;
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        $cities = $query->paginate($limit);

        $cities->setCollection(
            $cities->getCollection()->transform(function ($value) {
                return [
                    'id' => $value->id,
                    'name' => $value->name
                ];
            })
        );

        return $this->sendResponse(compact('cities'),"success");
    }
}
