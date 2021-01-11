<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Portfolio;
use App\Services;
use Illuminate\Http\Request;

class ProductSearchController extends Controller
{
    //


    public function index(Request $request)
    {


        $categories = Services::get();
        $products = Portfolio::inRandomOrder()->get();
        $brands = Brand::get();

        return view('site.product_list')
            ->with('categories', $categories)
            ->with('products', $products)
            ->with('brands', $brands)
            ;
        ;
    }
}
