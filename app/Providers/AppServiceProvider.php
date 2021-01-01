<?php

namespace App\Providers;

use App\Services;
use App\SiteInformation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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

        DB::listen(
            function ($query) {
                Log::info(
                    [
                        "Query" => $query->sql,
                        "Bindings" => $query->bindings,
                        "Time" => $query->time
                    ]
                );
            }
        );



        View::composer('*', function ($view) {
            // if(!Cache::has('site_information') || true) {
            //     Cache::add('site_information', SiteInformation::first(), 5000);
            // }

            // if(!Cache::has('site_menu_items') || true) {

            //     Cache::add('site_menu_items', $categories, 5000);
            // }
            //$siteInformation = Cache::get('site_information');
            //$categories = Cache::get('site_menu_items');
            $siteInformation = SiteInformation::first();
            $categories = Services::with(['products' => function($query) {
                $query->with('brand');
            }])->get();
            $user = auth()->user() ?? null;
            $view->with('categories', $categories);
            $view->with('siteInformation', $siteInformation);
            $view->with('user', $user);
        });

    }
}
