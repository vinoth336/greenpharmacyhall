<?php

namespace App\Imports;

use App\Product;
use App\Services;
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


        print_r($row);
        exit;

        $product = new Product();
        $product->product_code = $row['product_code'];
        $product->name = $row['product_name'];
        $product->slug = str_slug($row['product_name']);
        $product->brand_id = null;
        $product->sub_category_id = null;
        $product->description = 'import';
        $product->price = (float) $row['mrp'];
        $product->discount_amount = (float) ( $row['mrp'] == $row['price'] ? 0 : $row['price'] );
        $product->sequence = Product::count() + 1;
        $product->save();
        $category = Services::firstOrCreate(
            [
                'slug' => str_slug($row['category'])
            ],
            [
                'name' => ucfirst(strtolower($row['category'])),
                'category' => 1,
                'category_type_id' => 'be5c6581-c281-4622-8483-8022af05f75b',
                'description' => ucfirst(strtolower($row['category'])),
                'sequence' => Services::count() + 1
            ]
        );
        $product->services()->sync($category->id);

        $product->touch(); // This will help to add in cache

        return $product;
    }

}
