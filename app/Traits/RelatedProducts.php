<?php

namespace App\Traits;

use App\Product;

trait RelatedProducts {

    public function getRelatedProducts($limit = 6) {
        $relatedProducts = $this->getRelatedProductList($limit);

        return $relatedProducts;
    }


    public function getRelatedProductList($limit)
    {
        $query = Product::activeProject()->with(['brand', 'services']);
        $query = $this->addWhereCondition($query);

        return $query->select('products.*')->limit($limit)->inRandomOrder()->get();
    }

    public function getRandomProductList($limit)
    {
        $query = Product::activeProject()->with(['brand', 'services']);
        $query->where('products.id', '!=', $this->id);
        return $query->select('products.*')->limit($limit)->inRandomOrder()->get();
    }


    public function addWhereCondition($query)
    {
        $subCategories = $this->sub_category_id;
        $brand = $this->brand_id;
        $categories = $this->services()->pluck('services_id')->toArray();
        $productId = $this->id;

        $query->leftJoin('product_services', function($join) use($categories, $productId){
            $join->on('product_services.product_id', '=', 'products.id');
            $join->whereIn('product_services.services_id', $categories);
            $join->where('product_services.product_id', '!=', $productId);

        });

        $query->leftJoin('sub_categories', function($join) use($subCategories){
            $join->on('sub_categories.id', '=', 'products.sub_category_id');
            $join->where('sub_categories.id', '=', $subCategories);
        });

        $query->leftJoin('brands', function($join) use($brand){
            $join->on('brands.id', '=', 'products.brand_id');
            $join->where('brands.id', '=', $brand);
        });

        $query->where('products.id', '!=', $productId);
        return $query;

    }

}
