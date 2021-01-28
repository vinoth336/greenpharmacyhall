<?php

namespace App\Http\Controllers;

use App\Brand;
use App\CategoryType;
use App\Product;
use App\Services;
use App\SubCategory;
use Illuminate\Http\Request;
use Mockery\Matcher\Subset;

class ProductSearchController extends Controller
{
    //


    public function index(Request $request)
    {


        $categories = Services::get();
        $subCategories = SubCategory::get();
        $brands = Brand::get();
        $input = $request->all();

        $products = $this->getProducts($request, $renderPage = false);


        return view('site.product_list')
            ->with('categories', $categories)
            ->with('products', $products)
            ->with('brands', $brands)
            ->with('subCategories', $subCategories)
            ->with('input', $input)
            ;
        ;
    }


    public function getProducts(Request $request, $renderPage = true)
    {
        $products = Product::with(['brand', 'services']);
        $products = $this->addWhereCondition($request, $products);
        $sortBy = $request->input('sort_by') == 'low_to_high' ? 'asc' : 'desc';

        return $products->select('products.*')->orderBy('price', $sortBy)->get();
    }


    public function addWhereCondition($request, $products)
    {

        if($request->has('categories')) {
            $products->join('product_services', function($join) use($request, $products){
                $join->on('product_services.product_id', '=', 'products.id');
                $categories = filterRemoveEmptyValues($request->input('categories'));
                if($categories != '') {
                    $join->join('services', function($service_join) use($request, $categories){
                        $service_join->on('services.id', '=', 'product_services.services_id');
                        if(is_array($categories)) {
                            $service_join->whereIn('services.slug', $categories);
                        }else {
                            $service_join->where('services.slug', '=', $categories);
                        }
                        $service_join->on('product_services.services_id', '=', 'services.id');
                    });

                }
            });
        }

        if($request->has('sub_categories')) {
            $sub_categories = filterRemoveEmptyValues($request->input('sub_categories'));
            if($sub_categories) {
                $products->join('sub_categories', function($join) use($sub_categories){
                    $join->on('sub_categories.id', '=', 'products.sub_category_id');
                    if(is_array($sub_categories)) {
                        $join->whereIn('sub_categories.slug_name', $sub_categories);
                    }else {
                        $join->where('sub_categories.slug_name', '=', $sub_categories);
                    }
                });
            }
        }

        if($request->has('brands')) {
            $brands = filterRemoveEmptyValues($request->input('brands'));
            if($brands) {
                $products->join('brands', function($join) use($brands){
                    $join->on('brands.id', '=', 'products.brand_id');
                    if(is_array($brands)) {
                        $join->whereIn('brands.slug', $brands);
                    }else {
                        $join->where('brands.slug', '=', $brands);
                    }
                });
            }
        }

        return $products;

    }
}
