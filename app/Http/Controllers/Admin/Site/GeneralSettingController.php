<?php

namespace App\Http\Controllers\Admin\Site;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Traits\Admin\AdminMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GeneralSettingController extends Controller
{
    use AdminMethods;
    private $destination = "uploads/general_setting/";
    private $favdestination = "uploads/general_setting/favicon/";

    public function index()
    {
        $general_setting = GeneralSetting::count();
        if ($general_setting > 0) {
            $general_setting = GeneralSetting::first();
        } else {
            $general_setting = '';
        }
        return $this->view('admin.pages.general_setting.index', ['general_setting' => $general_setting]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'logo' => ['nullable', 'image', 'mimes:jpeg,jpg,png,svg', 'max:4096'],
            'favicon' => ['nullable', 'image', 'mimes:jpeg,jpg,png,svg', 'max:2048'],
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($validator->passes()) {
            try {
                $fields = [];
                DB::beginTransaction();
                if ($request->name != null || $request->hasFile('logo') || $request->hasFile('favicon')) {
                    if ($request->hasFile('logo')) {
                        if ($request->id != null) {
                            $general_setting = GeneralSetting::where('id', $request->id)->first();
                            $oldLogo = $general_setting->logo;
                        }
                        if (!file_exists($this->destination)) {
                            mkdir($this->destination, 0777, true);
                        }
                        // Upload Logo
                        $logo = $request->file('logo');
                        $logoName = time() . '.' . $logo->getClientOriginalExtension();
                        $fields['logo'] = $this->destination . $logoName;
                        $logo->move($this->destination, $logoName);
                    }

                    if ($request->hasFile('favicon')) {
                        if ($request->id != null) {
                            $general_setting = GeneralSetting::where('id', $request->id)->first();
                            $oldFavicon = $general_setting->favicon;
                        }
                        if (!file_exists($this->favdestination)) {
                            mkdir($this->favdestination, 0777, true);
                        }
                        // Upload Favicon
                        $fav = $request->file('favicon');
                        $favName = time() . '.' . $fav->getClientOriginalExtension();
                        $fields['favicon'] = $this->favdestination . $favName;
                        $fav->move($this->favdestination, $favName);
                    }

                    $fields['name'] = $request->name;
                    GeneralSetting::updateOrCreate([
                        'id' => $request->id,
                    ], $fields);
                }
                DB::commit();
                if ($request->id != null && $request->hasFile('logo')) {
                    if ($oldLogo != null && file_exists($oldLogo)) {
                        unlink($oldLogo);
                    }
                }
                if ($request->id != null && $request->hasFile('favicon')) {
                    if ($oldFavicon != null && file_exists($oldFavicon)) {
                        unlink($oldFavicon);
                    }
                }
                return redirect()->back()->with(notifyMsg('success', 'Site setting updated'));
            } catch (\Exception$e) {
                DB::rollBack();
                return redirect()->back()->with(notifyMsg('warning', $e->getMessage()));
            }
        }
    }
}
