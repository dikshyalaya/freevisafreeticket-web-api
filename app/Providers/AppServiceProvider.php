<?php

namespace App\Providers;

use App\Enum\SettingKey;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(env('FORCE_HTTPS',false)) {
            \URL::forceScheme('https');
        }

        global $this_action;
        $this_action = '';

        view()->composer('*', function ($view) {
            $view->with('current_locale', app()->getLocale());
            $view->with('available_locales', config('app.available_locales'));
            $view->with('footer_pages', Page::whereIn('title', ['Privacy Policy', 'Terms and Condition'])->get());
            $view->with([
                'general_setting' => GeneralSetting::first(),
                'social_settings' => Setting::whereIn('title', [SettingKey::FB_URL, SettingKey::GOOGLE_URL, SettingKey::LINKEDIN_URL, SettingKey::TWITTER_URL])->get(),
                'contact_settings' => Setting::whereIn('title', [SettingKey::ADDRESS, SettingKey::PHONE1, SettingKey::PHONE2, SettingKey::EMAIL])->get(),
                'store_settings' => Setting::whereIn('title', [SettingKey::GOOGLE_PLAY_STORE, SettingKey::APPLE_PLAY_STORE])->get(),
                'google_play_link' => Setting::whereTitle(SettingKey::GOOGLE_PLAY_STORE)->value('value'),
                'defaultCountryId' => Country::where('name', 'Nepal')->value('id'),
            ]);
        });
    }
}
