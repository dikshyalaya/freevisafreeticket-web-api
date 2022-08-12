<?php

namespace App\Providers;

use App\Extended\ExtendedTranslator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Translation\TranslationServiceProvider;

class ExtendedTranslationServiceProvider extends TranslationServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerLoader();
        $this->app->singleton('translator', function($app){
            $loader = $app['translation.loader'];
            $locale = $app['config']['app.locale'];
            $trans = new ExtendedTranslator($loader, $locale);
            $trans->setFallback($app['config']['app.fallback_locale']);
            return $trans;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
