<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Member;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderComponent extends Component
{
    public $categories;
    public $products;
    public $paymentMethods;
    public $selectedCategory = null;
    public $cart = [];
    public $message = null;
    public $isWarning = false;
    public $members = [];

    public $member_id = null;
    // discount
    public $discount_type = 'percent';
    public $discount_value = 0;

    public function render()
    {
        return view('livewire.order-component');
    }



    public function mount()
    {
        $this->categories = Category::all();
        $this->products = Product::all();
        $this->paymentMethods = PaymentMethod::where('is_active', 1)->get();
        $this->members = Member::all();
    }

    public function filterAllCategory()
    {
        $this->selectedCategory = null;
        $this->products = Product::all();
    }

    public function filterByCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        if ($categoryId == null) {
            $this->products = Product::all();
        } else {
            $this->products = Product::where('category_id', $categoryId)->get();
        }
    }


    public function addToCart($productId)
    {
        $product = Product::find($productId);

        if ($product->stock <= 0) {
            $this->isWarning = true;
            $this->message = "Stock $product->name sudah habis!";
            return;
        }

        if ($product) {

            $key = collect($this->cart)->search(function ($item) use ($productId) {
                return $item['id'] == $productId;
            });

            if ($key === false) {
                $this->cart[] = [
                    'id' => $product->id,
                    'image' => $product->image,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => 1,
                    'stock' => $product->stock,
                    'is_discount' => $product->is_discount,
                    'discount' => $product->discount,
                    'discount_type' => $product->discount_type,
                ];
                $this->isWarning = false;
                $this->message = "{$product->name} berhasil ditambahkan ke keranjang.";
            } else {
                $this->isWarning = true;
                $this->message = "{$product->name} sudah ada di keranjang!";
            }
        }
    }

    public function updateQuantity($productId, $quantity)
    {
        foreach ($this->cart as $index => $item) {
            if ($item['id'] == $productId) {
                $qty = max(1, min((int)$quantity, $item['stock']));
                $this->cart[$index]['quantity'] = $qty;
                $this->isWarning = false
;                $this->message = null;
                break;
            }
        }
        $this->cart = array_values($this->cart);
    }

    public function incrementQuantity($productId)
    {
        foreach ($this->cart as $index => $item) {
            if ($item['id'] == $productId) {
                // Ambil stok terbaru dari database (opsional, agar selalu up-to-date)
                $product = \App\Models\Product::find($productId);
                $maxStock = $product ? $product->stock : $item['stock'];

                if ($this->cart[$index]['quantity'] < $maxStock) {
                    $this->cart[$index]['quantity']++;
                    $this->cart[$index]['stock'] = $maxStock; 
                    $this->isWarning = false;
                    $this->message = null;
                } else {
                    $this->isWarning = true;
                    $this->message = "Stok {$item['name']} sudah maksimal ($maxStock)!";
                }
                // break agar tidak lanjut loop
                break;
            }
        }
        // Paksa Livewire render ulang
        $this->cart = array_values($this->cart);
    }

    public function decrementQuantity($productId)
    {
        foreach ($this->cart as $index => $item) {
            if ($item['id'] == $productId) {
                if ($this->cart[$index]['quantity'] > 1) {
                    $this->cart[$index]['quantity']--;
                    $this->isWarning = false;
                    $this->message = null;
                } else {
                    $this->isWarning = true;
                    $this->message = "Minimal pembelian 1 untuk {$item['name']}.";
                }
                break;
            }
        }
        $this->cart = array_values($this->cart);
    }

    public function removeFromCart($productId)
    {
        $this->isWarning = false;
        $this->message = "Berhasil menghapus produk dari cart!";
        $this->cart = array_values(array_filter($this->cart, function ($item) use ($productId) {
            return $item['id'] != $productId;
        }));
    }

    public function getSubtotalProperty()
    {
        return collect($this->cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    // Total = harga setelah diskon produk (jika ada)
    // public function getTotalProperty()
    // {
    //     return collect($this->cart)->sum(function ($item) {
    //         if (!empty($item['is_discount'])) {
    //             if ($item['discount_type'] === 'percent') {
    //                 $price = $item['price'] - ($item['price'] * $item['discount'] / 100);
    //             } else {
    //                 $price = $item['price'] - $item['discount'];
    //             }
    //         } else {
    //             $price = $item['price'];
    //         }
    //         return $price * $item['quantity'];
    //     });
    // }

    public $member = null;
    public $member_id_input = '';

    public function updatedMemberIdInput($value)
    {
        $this->member = \App\Models\Member::where('id', $value)->first();
        $this->member_id = $this->member ? $this->member->id : null;
    }

    public function checkMember()
    {
        if ($this->member_id_input) {
            $member = Member::where('id', $this->member_id_input)->first();
            if ($member) {
                $this->member = $member;
                $this->member_id = $member->id;
                $this->isWarning = false;
                $this->message = "Member ditemukan: {$member->name}";
            } else {
                $this->member = null;
                $this->member_id = null;
                $this->isWarning = true;
                $this->message = "Member  tidak ditemukan!";
            }
        } else {
            $this->member = null;
            $this->member_id = null;
            $this->isWarning = true;
            $this->message = "Silakan masukkan ID member!";
        }
    }

    public function getTotalProperty()
    {
        $subtotal = 0;
        foreach ($this->cart as $item) {
            $price = $item['price'];
            if (!empty($item['is_discount'])) {
                $price = $item['discount_type'] === 'percent'
                    ? $price - ($price * $item['discount'] / 100)
                    : $price - $item['discount'];
            }
            $subtotal += $price * $item['quantity'];
        }

        // Potongan member 5%
        if ($this->member_id) {
            $subtotal = $subtotal - ($subtotal * 0.05);
        }

        return $subtotal;
    }




    // save transaction


    public $payment_method_id;

    public function saveTransaction()
    {
        DB::beginTransaction();
        try {
            if (!$this->payment_method_id) {
                $this->isWarning = true;
                $this->message = 'Silakan pilih metode pembayaran!';
                return;
            }

            foreach ($this->cart as $item) {
                $product = Product::find($item['id']);
                if ($item['quantity'] > $product->stock) {

                    $this->isWarning = true;
                    $this->message = "Stok {{$item['name']}} tidak cukup! Maksimal {{$product->stock}}.";
                    DB::rollBack();
                    return;
                }
            }

            $transaction = Transaction::create([
                'member_id' => $this->member_id,
                'total_amount' => $this->total,
                'status' => 'pending',
                'payment_method_id' => $this->payment_method_id, // <-- tambahkan baris ini
                'created_by' => Auth::id(),
            ]);



            foreach ($this->cart as $item) {
                // Hitung harga setelah diskon
                if (!empty($item['is_discount'])) {
                    if ($item['discount_type'] === 'percent') {
                        $price = $item['price'] - ($item['price'] * $item['discount'] / 100);
                    } else {
                        $price = $item['price'] - $item['discount'];
                    }
                } else {
                    $price = $item['price'];
                }




                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $price,
                    'total' => $price * $item['quantity'],
                ]);
            }


            $this->filterAllCategory();




            DB::commit();

            $this->cart = [];
            $this->isWarning = false;
            $this->message = 'Transaksi berhasil disimpan!';
            return redirect("/transaction/{$transaction->id}/payment");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->isWarning = true;
            $this->message = 'Gagal menyimpan transaksi: ' . $e->getMessage();
        }
    }


    // scan, write barcode result and search the code on product
    public $barcode = '';
    public function scanBarcode()
    {
        if (!$this->barcode) return;

        $product = Product::where('sku', $this->barcode)->first();

        if ($product) {
            $this->addToCart($product->id);
            $this->barcode = ''; // reset input after scan
        } else {
            $this->isWarning = true;
            $this->message = "Produk dengan barcode {$this->barcode} tidak ditemukan!";
            $this->barcode = '';
        }
    }
}
