<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Traits\Admin\AdminMethods;
use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    use AdminMethods;

    private $page = 'admin.pages.country.';

    private $redirectTo = 'admin.country.index';

    public function index()
    {
        return $this->view($this->page.'index', [
            'countries' => Country::select('id', 'name', 'iso2', 'iso3', 'phonecode', 'currency', 'currency_name', 'currency_symbol', 'is_active')->paginate(10),
        ]);
    }

    public function create()
    {
        return $this->view($this->page.'editadd',[
            'action' => 'Create'
        ]);
    }

    public function edit($id)
    {
        $country = Country::findOrFail($id);
        return $this->view($this->page.'editadd',[
            'country' => $country,
            'action' => 'Edit'
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'unique:countries,name,'.$request->id],
            'iso2' => ['required'],
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if($validator->passes()){
            try{
                Country::updateOrCreate([
                    'id' => $request->id,
                ],[
                    'name' => $request->name,
                    'iso3' => $request->iso3 ? strtoupper($request->iso3) : null,
                    'iso2' => $request->iso2 ? strtoupper($request->iso2) : null,
                    'phonecode' => $request->phonecode ?? null,
                    'currency' => $request->currency ? strtoupper($request->currency) : null,
                    'currency_name' => $request->currency_name ?? null,
                    'currency_symbol' => $request->currency_symbol ?? null,
                    'is_active' => $request->is_active ? 1 : 0
                ]);
                $msg = $request->id == '' ? 'Country created successfully' : 'Country updated successfully';
                return redirect()->route($this->redirectTo)->with(notifyMsg('success', $msg));
            } catch(\Exception $e){
                return redirect()->back()->with(notifyMsg('warning', $e->getMessage()));
            }
        }
    }

    public function delete($id)
    {
        Country::destroy($id);
        return redirect()->back()->with(notifyMsg('success', 'Country deleted successfully'));
    }


    public function updateStatus(Request $request)
    {
        $country = Country::where("id", $request->country_id)->first();
        if($country->is_active == 0){
            $country->update(["is_active"=>1]);
            $msg = "Country is active";
        } else {
            $country->update(["is_active"=>0]);
            $msg = "Country is inactive";
        }
        $status = $country->is_active;
        return response()->json(["msg"=>$msg, "status"=>$status]);
    }

    
}
