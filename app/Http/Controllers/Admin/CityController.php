<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Traits\Admin\AdminMethods;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    use AdminMethods;

    private $page = "admin.pages.city.";
    private $redirectTo = "admin.city.index";

    public function __construct()
    {
        $this->countries = Country::select('id', 'name')->get();
    }

    public function index()
    {
        return $this->view($this->page.'index',[
            'cities' => City::with(['country:id,name', 'state:id,name'])->paginate(10),
        ]);
    }

    public function create()
    {
        return $this->view($this->page.'editadd',[
            'countries' => $this->countries,
            'action' => 'Create'
        ]);
    }

    public function edit($id)
    {
        $city = City::findOrFail($id);
        return $this->view($this->page.'editadd', [
            'city' => $city,
            'countries' => $this->countries,
            'action' => 'Edit'
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => ['required'],
            'country_id' => ['required'],
            'state_id' => ['required'],
        ],[
            'country_id.required' => 'Country is required',
            'state_id.required' => 'State is required'
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if($validator->passes()){
            try{
                $country_code = Country::where('id', $request->country_id)->value('iso2');
                $state_code = State::where('id', $request->state_id)->value('iso2');
                City::updateOrCreate([
                    'id' => $request->id,
                ],[
                    'name' => $request->name,
                    'country_id' => $request->country_id,
                    'state_id' => $request->state_id,
                    'state_code' => $state_code,
                    'country_code' => $country_code,
                ]);
                $msg = $request->id == '' ? 'created' : 'updated';
                return redirect()->route($this->redirectTo)->with(notifyMsg('success', 'City '.$msg. ' successfully'));
            } catch(\Exception $e){
                return redirect()->back()->with(notifyMsg('warning', $e->getMessage()));
            }
        }
    }

    public function delete($id)
    {
        City::destroy($id);
        return redirect()->back()->with(notifyMsg('success', 'City deleted'));
    }
}
