<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Auth;

class ProductsImportCSV implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Find or create category
            $category = null;
            if (!empty($row['category'])) {
                $category = Category::firstOrCreate(
                    ['name' => $row['category']],
                    [
                        'description' => 'Imported category',
                        'created_by' => Auth::id()
                    ]
                );
            }

            // Create or update product
            $product = Product::updateOrCreate(
                ['sku' => $row['sku']],
                [
                    'name' => $row['name'],
                    'price' => $row['price'],
                    'stock' => $row['stock'] ?? 0,
                    'unit' => $row['unit'] ?? 'pcs',
                    'category_id' => $category ? $category->id : 1, 
                    'description' => $row['description'] ?? '',
                    'is_active' => $this->parseBoolean($row['is_active'] ?? 'Yes'),
                    'is_discount' => $this->parseBoolean($row['is_discount'] ?? 'No'),
                    'discount_type' => $row['discount_type'] ?? null,
                    'discount' => $row['discount_value'] ?? null,
                    'created_by' => Auth::id()
                ]
            );
        }
    }

    private function parseBoolean($value)
    {
        return in_array(strtolower($value), ['yes', 'true', '1', 'y']);
    }

    public function rules(): array
    {
        return [
            '*.name' => 'required|string|max:255',
            '*.sku' => 'required|string|max:255',
            '*.price' => 'required|numeric|min:0',
            '*.stock' => 'nullable|numeric|min:0',
            '*.unit' => 'nullable|string|max:255',
            '*.category' => 'nullable|string|max:255',
            '*.is_active' => 'nullable|string',
            '*.is_discount' => 'nullable|string',
            '*.discount_type' => 'nullable|string|in:percent,amount',
            '*.discount_value' => 'nullable|numeric|min:0',
        ];
    }
}