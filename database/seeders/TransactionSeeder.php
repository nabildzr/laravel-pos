<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $currentYear = now()->year;
        
       
        for ($month = 1; $month <= 12; $month++) {
            $transactionCount = match(true) {
                $month >= 10 => rand(15, 25), 
                $month >= 7 => rand(10, 20),
                $month >= 4 => rand(5, 15),
                default => rand(3, 10),
            };
            
            $this->createTransactionsForMonth($currentYear, $month, $transactionCount);
        }
        
        $this->createTransactionsForToday(rand(3, 8));
    }
    
    private function createTransactionsForMonth(int $year, int $month, int $count): void
    {
        $startDate = \Carbon\Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = \Carbon\Carbon::create($year, $month, 1)->endOfMonth();
        
        for ($i = 0; $i < $count; $i++) {
            $date = fake()->dateTimeBetween($startDate, $endDate);
            
            DB::transaction(function() use ($date) {
                $transaction = Transaction::factory()->create([
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
                
                // 5 items
                $itemCount = rand(1, 5);
                $totalAmount = 0;
                
                for ($j = 0; $j < $itemCount; $j++) {
                    $product = Product::inRandomOrder()->first();
                    if (!$product) continue;
                    
                    $quantity = rand(1, 3);
                    $price = $product->price;
                    
                    
                    if ($product->is_discount) {
                        if ($product->discount_type === 'percentage') {
                            $price = $price * (1 - ($product->discount / 100));
                        } else {
                            $price = $price - $product->discount;
                        }
                    }
                    
                    $itemTotal = $price * $quantity;
                    $totalAmount += $itemTotal;
                    
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'quantity' => $quantity,
                        'price' => $price,
                        'total' => $itemTotal,
                        'created_at' => $date,
                        'updated_at' => $date,
                    ]);
                    
                    $product->decrement('stock', $quantity);
                }
                
                $transaction->update([
                    'total_amount' => $totalAmount,
                    'paid_amount' => $transaction->status === 'paid' ? $totalAmount : 0,
                    'return_amount' => 0,
                ]);
            });
        }
    }
    
    private function createTransactionsForToday(int $count): void
    {
        $today = now();
        
        for ($i = 0; $i < $count; $i++) {
            $hours = rand(8, 23);
            $minutes = rand(0, 59);
            $date = $today->copy()->setTime($hours, $minutes);
            
            DB::transaction(function() use ($date) {
                $transaction = Transaction::factory()->create([
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
                
                // 5 items aga
                $itemCount = rand(1, 5);
                $totalAmount = 0;
                
                for ($j = 0; $j < $itemCount; $j++) {
                    $product = Product::inRandomOrder()->first();
                    if (!$product) continue;
                    
                    $quantity = rand(1, 3);
                    $price = $product->price;
                    
                    if ($product->is_discount) {
                        if ($product->discount_type === 'percentage') {
                            $price = $price * (1 - ($product->discount / 100));
                        } else {
                            $price = $price - $product->discount;
                        }
                    }
                    
                    $itemTotal = $price * $quantity;
                    $totalAmount += $itemTotal;
                    
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'quantity' => $quantity,
                        'price' => $price,
                        'total' => $itemTotal,
                        'created_at' => $date,
                        'updated_at' => $date,
                    ]);
                    
                    $product->decrement('stock', $quantity);
                }
                
                $transaction->update([
                    'total_amount' => $totalAmount,
                    'paid_amount' => $transaction->status === 'paid' ? $totalAmount : 0,
                    'return_amount' => 0,
                ]);
            });
        }
    }
}