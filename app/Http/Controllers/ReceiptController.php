<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function print(Transaction $transaction)
    {
        $transaction->load('transactionDetails.product', 'user', 'member');
        
        return view('receipts.print', compact('transaction'));
    }
}