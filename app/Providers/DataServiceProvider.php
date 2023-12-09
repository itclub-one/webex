<?php

namespace App\Providers;

use App\Models\admin\Sekbid;
use App\Models\admin\Setting;
use Illuminate\Support\ServiceProvider;

class DataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer([
            'administrator.layouts.main',
            'administrator.authentication.main',
            'administrator.authentication.login',
            'administrator.logs.export',
            'frontpage.layouts.header',
            'frontpage.layouts.main',
            'frontpage.kepala_sekolah.index',
            'frontpage.wakil_kepala_sekolah.index',
            'frontpage.pendaftaran.index'
        ], function ($view) {
            $settings = Setting::get()->toArray();
        
            $settings = array_column($settings, 'value', 'name');
            $view->with('settings', $settings);
        });
        
        view()->composer('frontpage.layouts.header_explore', function ($view) {
            $sekbid = Sekbid::with('eskul')->get();
        
            $view->with('sekbid', $sekbid);
        });
    }
}
