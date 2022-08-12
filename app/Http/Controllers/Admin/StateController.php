<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;
use App\Traits\Admin\AdminMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StateController extends Controller
{
    use AdminMethods;

    private $page = "admin.pages.state.";
    private $redirectRoute = "admin.state.index";

    public function __construct()
    {
        $this->countries = Country::select('id', 'name', 'iso2')->get();
    }

    public function index()
    {
        return $this->view($this->page . 'index', [
            'states' => State::with(['country:id,name'])->paginate(10),
        ]);
    }

    public function create()
    {
        return $this->view($this->page . 'editadd', [
            'countries' => $this->countries,
            'action' => 'Create'
        ]);
    }

    public function edit($id)
    {
        $state = State::findOrFail($id);
        return $this->view($this->page . 'editadd', [
            'state' => $state,
            'countries' => $this->countries,
            'action' => 'Edit'
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'country_id' => ['required'],
            'iso2' => ['required'],
        ], [
            'country_id.required' => 'Select country',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($validator->passes()) {
            $country_code = Country::where('id', $request->country_id)->first()->iso2;
            try {
                State::updateOrCreate([
                    'id' => $request->id,
                ], [
                    'name' => $request->name,
                    'country_id' => $request->country_id,
                    'country_code' => $country_code,
                    'fips_code' => $request->fips_code ?? null,
                    'iso2' => $request->iso2 ?? null,
                ]);
                $msg = $request->id == '' ? 'created' : 'updated';
                return redirect()->route($this->redirectRoute)->with(notifyMsg('success', 'State ' . $msg . ' successfully'));
            } catch (\Exception$e) {
                return redirect()->back()->with(notifyMsg('warning', $e->getMessage()));
            }
        }
    }

    public function delete($id)
    {
        State::destroy($id);
        return \redirect()->back()->with(notifyMsg('success', 'State deleted successfully'));
    }
}
