<?php

use App\Services;
use App\SiteInformation;
use App\UserOrder;
use Illuminate\Support\Facades\Cache;

function getSiteMenus()
{
    $categories = Services::with(['products' => function ($query) {
                    $query->with('sub_category');
                }])->get();

    return $categories;
}

function setSiteMenuValueInCache($categories, $ttl=5000)
{
    Cache::forget('site_menu_items');
    Cache::add('site_menu_items', $categories, $ttl);
}

function setSiteInformationInCache()
{
    Cache::forget('site_information');
    Cache::add('site_information', SiteInformation::first(), 5000);
}

function orderNumber()
{
    $latest = UserOrder::latest()->first();
    if (! $latest) {
        return date("Y")."00125";
    }

    $string = preg_replace("/[^0-9\.]/", '', $latest->order_no);

    return sprintf('%04d', $string+1);
}


function filterRemoveEmptyValues($input)
{
    if(!is_array($input)) {
        $temp = $input;
        $input = [$temp];
    }
    $newValues = [];

    foreach($input as $key => $value) {
        if($value !='' && $value != 'all') {
            $newValues[$key] = $value;
        }
    }

    return count($newValues) ? null : $newValues;
}
