<?php

namespace App\Exports;

use App\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportProductData implements FromCollection, WithMapping, WithHeadings, WithEvents
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::with('brand', 'services', 'sub_category', 'productImages')->orderBy('name')->get();
    }

    public function headings(): array
    {
        return [
            'Product Name',
            'Product Code',
            'Services',
            'Sub Categories',
            'Brand',
            'Price',
            'Discount Price',
            'Image Status',
            'Status'
        ];
    }

    public function map($product) : array {

        return [
            ucwords($product->name),
            $product->product_code,
            implode(', ' ,$product->services()->pluck('name')->toArray()),
            implode(', ' ,$product->sub_category()->pluck('name')->toArray()),
            $product->brand ?  $product->brand->name : null,
            number_format($product->price, 2),
            number_format($product->discount_amount, 2),
            $product->productImages->count() > 0 ? 'Had Image' : 'No Image',
            $product->status ? 'Active' : 'Not Active'
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:Z1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(11);
            },
        ];
    }
}
