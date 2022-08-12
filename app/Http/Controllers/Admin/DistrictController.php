<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Traits\Admin\AdminMethods;
use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Support\Facades\Validator;

class DistrictController extends Controller
{
    use AdminMethods;

    private $page = "admin.pages.district.";
    private $redirectTo = "admin.district.index";

    public function __construct()
    {
        $this->countries = Country::select('id', 'name')->get();
    }

    public function index()
    {
        return $this->view($this->page.'index',[
            'districts' => District::with(['state:id,name'])->paginate(10),
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
        $district = District::findOrFail($id);
        return $this->view($this->page.'editadd',[
            'district' => $district,
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
            'state_id.required' => 'State is required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if($validator->passes()){
            try{
                District::updateOrCreate([
                    'id' => $request->id,
                ],[
                    'name' => $request->name,
                    'state_id' => $request->state_id,
                ]);
                $msg = $request->id == '' ? 'created' : 'updated';
                return redirect()->route($this->redirectTo)->with(notifyMsg('success', 'District '.$msg.' successfully'));
            } catch(\Exception $e){
                return redirect()->back()->with(notifyMsg('warning', $e->getMessage()));
            }
        }
    }

    public function delete($id)
    {
        District::destroy($id);
        return redirect()->back()->with(notifyMsg('success', 'District deleted'));
    }


}
