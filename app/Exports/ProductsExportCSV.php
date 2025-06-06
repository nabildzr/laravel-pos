<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExportCSV implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Product::with(['category', 'user'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'SKU',
            'Price',
            'Stock',
            'Unit',
            'Category',
            'Description',
            'Is Active',
            'Is Discount',
            'Discount Type',
            'Discount Value',
        ];
    }

    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            $product->sku,
            $product->price,
            $product->stock,
            $product->unit,
            $product->category ? $product->category->name : '',
            $product->description,
            $product->is_active ? 'Yes' : 'No',
            $product->is_discount ? 'Yes' : 'No',
            $product->discount_type,
            $product->discount,
        ];
    }
}