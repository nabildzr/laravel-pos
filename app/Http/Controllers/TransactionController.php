<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::orderBy('created_at', 'desc')->get();

    

        return view('transactions.index')->with([
            'transactions' => $transactions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = \App\Models\Transaction::with('details')->findOrFail($id);

        if($transaction->status === "paid" || $transaction->status === "cancelled") {
            return redirect('transaction');
        }

        return view('transactions.show', [
            'transaction' => $transaction,
            'transactionDetail' => $transaction->details,
        ]);
    }

    public function showInvoice(string $id)
    {
        $transaction = \App\Models\Transaction::with('details')->findOrFail($id);

        if($transaction->status === "pending") {
            return redirect('transaction');
        }

        return view('transactions.show', [
            'isInvoice' => true,
            'transaction' => $transaction,
            'transactionDetail' => $transaction->details,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
