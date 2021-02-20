<?php

namespace App\Imports;

use App\Brand;
use App\Product;
use App\Services;
use App\SubCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportProduct implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $product = Product::firstOrCreate(
            ['slug' => str_slug($row['product_name'])],
            [
                'slug' => str_slug($row['product_name']),
                'name' => ucfirst(strtolower($row['product_name'])),
                'description' => ''
            ]
        );


        $product->product_code = $row['product_code'];
        $product->brand_id = null;
        $product->sub_category_id = null;
        $product->price = (float) $row['mrp'];
        $product->discount_amount = (float) ($row['mrp'] == $row['price'] ? 0 : $row['price']);
        $product->sequence = 1;
        $product->sub_category_id = $this->getSubCategory($row);
        $product->brand_id = $this->getBrand($row);
        $product->save();
        if($categories = $this->getCategories($row)) {
            $product->services()->sync($categories);
        }

        return $product;
    }


    public function getCategories($row)
    {
        $categoryIds = null;
        if($row['categories'] != '') {
            $categories = explode(",", $row['categories']);
            foreach($categories as $slug) {
                $slug = trim($slug);
                $category = Services::firstOrCreate(
                    [
                        'slug' => str_slug($slug)
                    ],
                    [
                        'slug' => str_slug($slug),
                        'name' => ucfirst(strtolower($slug)),
                        'category' => 1,
                        'category_type_id' => 'be5c6581-c281-4622-8483-8022af05f75b',
                        'description' => ucfirst(strtolower($slug)),
                        'sequence' => 1
                    ]
                );
                $categoryIds[] = $category->id;
            }
            return $categoryIds;
        }

        return null;
    }

    public function getSubCategory($row)
    {
        if($row['sub_category'] != '') {
            $subCategory = SubCategory::firstOrCreate(
                [
                    'slug_name' => str_slug($row['sub_category'])
                ],
                [
                    'slug_name' => str_slug($row['sub_category']),
                    'name' => ucfirst(strtolower($row['sub_category'])),
                    'sequence' => 1
                ]
            );
            return $subCategory->id ?? null;
        }

        return null;
    }

    public function getBrand($row)
    {
        if($row['brand'] != '') {
            $brand = Brand::firstOrCreate(
                [
                    'slug' => str_slug($row['brand'])
                ],
                [
                    'slug' => str_slug($row['brand']),
                    'name' => ucfirst(strtolower($row['brand'])),
                    'sequence' => 1
                ]
            );
            return $brand->id ?? null;
        }

        return null;
    }
}
