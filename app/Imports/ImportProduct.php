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
        $product->save();
        $category = Services::firstOrCreate(
            [
                'slug' => str_slug($row['category'])
            ],
            [
                'slug' => str_slug($row['category']),
                'name' => ucfirst(strtolower($row['category'])),
                'category' => 1,
                'category_type_id' => 'be5c6581-c281-4622-8483-8022af05f75b',
                'description' => ucfirst(strtolower($row['category'])),
                'sequence' => 1
            ]
        );
        $product->services()->sync($category->id);

        return $product;
    }
}
