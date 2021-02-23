<?php

namespace App\Providers;

use App\Brand;
use App\Services;
use App\SiteInformation;
use App\SubCategory;
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

        if(env('APP_ENV') != 'production') {
            DB::listen(
                function ($query) {
                    Log::info(
                        [
                            "Query" => $query->sql,
                            "Bindings" => $query->bindings,
                            "Time" => $query->time
                        ]
                    );
                });
        }


        View::composer('*', function ($view) {

            if (!Cache::has('site_information')) {
                setSiteInformationInCache();
            }
            if (!Cache::has('site_menu_items')) {
                setSiteMenuValueInCache(getSiteMenus());
            }
            $siteInformation = Cache::get('site_information');
            $categories = Cache::get('site_menu_items');
            $subCategories = SubCategory::get();
            $brands = Brand::get();
            $input = request()->all();
            $user = auth()->user() ?? null;
            $view->with('categories', $categories);
            $view->with('siteInformation', $siteInformation);
            $view->with('user', $user);
            $view->with('version', '1.0.14');
            $view->with('subCategories', $subCategories);
            $view->with('brands', $brands);
            $view->with('input', $input);
        });
    }
}
