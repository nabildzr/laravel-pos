<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = PaymentMethod::all();

        return view('payment-method.index')->with([
            'paymentMethods' => $payments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('payment-method.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = $request->validate(
            [
                'name' => 'required|string|max:255',
                'provider' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'is_active' => 'required|boolean',

            ]
        );


        $rules['created_by'] = Auth::user()->id;

        $input = $rules;

        $status = PaymentMethod::create($input);

        if ($status) {
            return redirect('payment-method')->with('success', 'Payment Method successfully added');
        } else {
            return back()->with('error', 'Failed to add Payment Method');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payment = PaymentMethod::findOrFail($id);

        if (!$payment) {
            return redirect('payment-method')->with('error', 'Payment Method not found');
        }

        return view('payment-method.form')->with([
            'result' => $payment
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payment = PaymentMethod::findOrFail($id);

        $rules = $request->validate([
            'name' => 'required|string|max:255',
            'provider' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $input = $rules;

        $status = $payment->update($input);

        if ($status) {
            return redirect('payment-method')->with([
                'success' => 'Payment Method Successfully Updated'
            ]);
        }

        return back()->with([
            'error' => 'Failed to update Payment Method'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);

        if (in_array(strtolower($paymentMethod->name), ['cash', 'transfer'])) {
            return back()->with('error', 'This Payment Method can\'t be deleted');
        }

        if ($paymentMethod->delete()) {
            return redirect('payment-method')->with('success', 'Payment Method successfully deleted');
        } else {
            return back()->with('error', 'Failed to delete Payment Method');
        }
    }
}
