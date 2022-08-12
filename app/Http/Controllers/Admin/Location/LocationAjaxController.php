<?php

namespace App\Http\Controllers\Admin\Location;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\District;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationAjaxController extends Controller
{
    public function countries(Request $request){
        $countries= Country::select('id', 'name')->where('is_active', 1);
        return \Response::json($countries->get());
    }
    public function states(Request $request){
        $states= State::query();
        $states->select('id','name', 'country_id');
        $states->where('country_id',$request->country_id);
        return  \Response::json($states->get());
    }
    public function cities(Request $request){
        $cities= City::query();
        $cities->select('id','name', 'state_id','country_id');
        $cities->where('state_id',$request->state_id);
        return \Response::json($cities->get());
    }

    public function districts(Request $request)
    {
        $districts = District::query();
        $districts->where('state_id', $request->state_id);
        return \Response::json($districts->get());
    }
}
