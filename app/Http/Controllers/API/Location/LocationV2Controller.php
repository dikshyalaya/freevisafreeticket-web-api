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

        if ($request->has("country_id")) {           
            $query->where('id',  $request->country_id);
        }

        if ($request->has("search_query")) {
            $searchTerm = $request->search_query;
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        $countries = $query->paginate($limit);

        $countries->transform(function ($value) {
            return [
                'id' => $value->id,
                'name' => $value->name,
                'native' => $value->native,
                'native' => $value->native,
                'flag' => "assets/images/flags/".strtolower($value->iso2).".svg",
                'phone_code'=> $value->phonecode,
                'currency'=>[
                    'currency_name' => $value->currency_name,
                    'currency_code' => $value->currency,
                    'currency_symbol' => $value->currency_symbol],
                //'region' => $value->subregion,
                //'timezones' => json_decode($value->timezones),
            ];
        });
        
        return $countries;
    }

    public function states(Request $request)
    {
        $limit = $request->has("limit") ? $request->limit : 10;
        $query = State::query();

        if ($request->has("id")) {
            $id = $request->id;
            $query->where('id', '=', $id);
        }

        if ($request->has("country_id")) {
            $country_id = $request->country_id;
             $query->where('country_id', '=', $country_id);
        }

        if ($request->has("search_query")) {
            $searchTerm = $request->search_query;
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        $states = $query->paginate($limit);
        return $states;
        
    }

    public function cities(Request $request)
    {
        $limit = $request->has("limit") ? $request->limit : 10;
        $query = City::query();

        if ($request->has("id")) {
            $id = $request->id;
            $query->where('id', '=', $id);
        }

        if ($request->has("country_id")) {
            $country_id = $request->country_id;
            $query->where('country_id', '=', $country_id);
        }

        if ($request->has("state_id")) {
            $state_id = $request->state_id;
            $query->where('state_id', '=', $state_id);
        }


        if ($request->has("search_query")) {
            $searchTerm = $request->search_query;
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        $cities = $query->paginate($limit);

       
            $cities->getCollection()->transform(function ($value) {
                return [
                    'id' => $value->id,
                    'name' => $value->name,
                    'country' => $value->country,
                    'state' => $value->state
                ];
            });
        

            return $cities;
    }

}
