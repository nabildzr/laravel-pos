<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;

class TransactionPayment extends Component
{
    public $id; // <--- tambahkan ini
    public $transaction;
    public $transactionDetail;
    public $status = 'pending';
    public $paid_amount = 10000;
    public $change = 0;
    public $note;
    public $isInvoice;
    public $changeTextButton = "Hitung Kembalian";


    public function mount()
    {
        $this->status = $this->transaction->status ?? 'pending';
        $this->paid_amount = in_array($this->transaction->status, ["paid", "cancelled"]) ? $this->transaction->paid_amount : $this->paid_amount;
        $this->change = in_array($this->transaction->status, ["paid", "cancelled"]) ? $this->transaction->return_amount : $this->change;

    }

    public function render()
    {
        return view('livewire.transaction-payment');
    }



    public function updateChange()
    {
        $this->change = max(0, (int)$this->paid_amount - (int)$this->transaction['total_amount']);
        $this->changeTextButton = "Hitung Kembalian!";
    }

    public function updatedPaidAmount()
    {
        $this->updateChange();
        $this->changeTextButton = "Menghitung...";
    }

    public function statusChanged()
    {
        if ($this->status !== 'paid') {
            $this->paid_amount = 0;
            $this->change = 0;
        }
    }

    public function save()
    {
        $this->transaction->status = $this->status;
        if ($this->status === 'paid') {

            $this->transaction->paid_amount = $this->paid_amount;
            $this->transaction->return_amount = $this->change;
        }

        if ($this->status === 'pending') {
            $this->transaction->note = $this->note;
        }

        $this->transaction->save();

        session()->flash('success', 'Transaksi diperbarui!');
        return redirect("/invoice/{$this->transaction->id}");
    }

    public function appendToAmount($digit)
    {
        // Penanganan kondisi angka 0
        if ($this->paid_amount == 0) {
            if ($digit === '000') {
                $this->paid_amount = 0;
            } else {
                // Ganti nilai 0 dengan digit baru
                $this->paid_amount = $digit;
            }
        } else {
            // Untuk angka 000, kalikan dengan 1000
            if ($digit === '000') {
                $this->paid_amount = $this->paid_amount * 1000;
            } else {
                // Ubah ke string, tambahkan digit, dan kembalikan ke integer
                $currentVal = (string) $this->paid_amount;
                $newVal = $currentVal . $digit;
                $this->paid_amount = (int) $newVal;
            }
        }

        // Hitung kembalian secara otomatis
        $this->calculateChange();
    }

    public function clearAmount()
    {
        $this->paid_amount = 0;
        $this->calculateChange();
    }

    public function eraseAmount()
    {
        $current = (string) $this->paid_amount;
        // Hapus satu digit terakhir
        $current = mb_substr($current, 0, -1);
        // Jika kosong, set ke 0
        $this->paid_amount = $current === '' ? 0 : (int)$current;
        $this->calculateChange();
    }

    public function setQuickAmount($amount)
    {
        $this->paid_amount = $amount;
        $this->calculateChange();
    }



    protected function calculateChange()
    {
        if ($this->paid_amount >= $this->transaction->total_amount) {
            $this->change = $this->paid_amount - $this->transaction->total_amount;
        } else {
            $this->change = 0;
        }
    }
}
