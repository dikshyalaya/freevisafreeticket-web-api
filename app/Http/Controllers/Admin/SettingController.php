<?php

namespace App\Http\Controllers\Admin;

use App\Enum\SettingKey;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\Admin\AdminMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    use AdminMethods;

    public function index()
    {
        $settings = Setting::whereIn('title', [SettingKey::FB_URL, SettingKey::GOOGLE_URL, SettingKey::LINKEDIN_URL, SettingKey::TWITTER_URL, SettingKey::GOOGLE_PLAY_STORE, SettingKey::APPLE_PLAY_STORE])->get();
        return $this->view('admin.pages.setting.index', ['settings' => $settings]);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->title as $key => $title) {
                if ($request->get('value')[$key] != null and !filter_var($request->get('value')[$key], FILTER_VALIDATE_URL)) {
                    return redirect()->back()->with(notifyMsg('error', ucwords(str_replace('_', ' ', $title)) . ' is not valid url'))->withInput();
                }
                Setting::updateOrCreate([
                    'title' => $title,
                ], [
                    'title' => $title,
                    'value' => $request->get('value')[$key],
                ]);
            }
            DB::commit();
            return redirect()->back()->with(notifyMsg('success', 'Social Setting updated successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(notifyMsg('warning', $e->getMessage()));
        }
    }

    public function getContactSetting()
    {
        $settings = Setting::whereIn('title', [SettingKey::ADDRESS, SettingKey::PHONE1, SettingKey::PHONE2, SettingKey::EMAIL])->get();
        return $this->view('admin.pages.setting.contactsetting', ['settings' => $settings]);
    }

    public function saveContactSetting(Request $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->title as $key => $title) {
                Setting::updateOrCreate([
                    'title' => $title,
                ], [
                    'title' => $title,
                    'value' => $request->get('value')[$key],
                ]);
            }
            DB::commit();
            return redirect()->back()->with(notifyMsg('success', 'Contact Setting updated successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(notifyMsg('warning', $e->getMessage()));
        }
    }
}
