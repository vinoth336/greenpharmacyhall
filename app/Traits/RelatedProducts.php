<?php

namespace App\Traits;

use App\Product;

trait RelatedProducts {

    public function getRelatedProducts($limit = 10) {
        $relatedProducts = $this->getRelatedProductList($limit);

        return $relatedProducts;
    }


    public function getRelatedProductList($limit)
    {
        $query = Product::with(['brand', 'services']);
        $query = $this->addWhereCondition($query);

        return $query->select('products.*')->limit($limit)->inRandomOrder()->get();
    }

    public function getRandomProductList($limit)
    {
        $query = Product::with(['brand', 'services']);
        $query->where('products.id', '!=', $this->id);
        return $query->select('products.*')->limit($limit)->inRandomOrder()->get();
    }


    public function addWhereCondition($query)
    {
        $subCategories = $this->sub_category_id;
        $brand = $this->brand_id;
        $query->join('sub_categories', function($join) use($subCategories){
            $join->on('sub_categories.id', '=', 'products.sub_category_id');
            $join->where('sub_categories.slug_name', '=', $subCategories);
        });

        $query->join('brands', function($join) use($brand){
            $join->on('brands.id', '=', 'products.brand_id');
            $join->where('brands.slug', '=', $brand);
        });

        $query->where('products.id', '!=', $this->id);
        return $query;

    }

}
