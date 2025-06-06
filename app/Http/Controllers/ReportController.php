<?php

namespace App\Http\Controllers;

use App\Exports\ExpensesExport;
use App\Exports\ProductSalesReportExport;
use App\Exports\SalesReportExport;
use App\Exports\TransactionInfoExport;
use App\Exports\TransactionSummaryExport;
use App\Models\Expense;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ReportController extends Controller
{

    // expense
    public function expenseView()
    {
        $expenses = Expense::orderBy('created_at', 'desc')->get();
        return view('reports.expense')->with([
            'expenses' => $expenses
        ]);
    }


    public function exportExpense(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ]);

        $from = $request->from;
        $to = $request->to;

        return Excel::download(new ExpensesExport($from, $to), "expenses-{$from}-to-{$to}.xlsx");
    }

    public function exportExpensePDF(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ]);

        $from = $request->from;
        $to = $request->to;

        $expenses = Expense::with(['user', 'expenseCategory', 'approver'])
            ->whereBetween('date', [$from, $to])
            ->orderBy('date', 'desc')
            ->get();

        $pdf = FacadePdf::loadView('reports.pdf.expense-pdf', [
            'expenses' => $expenses,
            'from' => $from,
            'to' => $to
        ]);

        return $pdf->download("expenses-{$from}-to-{$to}.pdf");
    }

    // sales
    public function salesView()
    {
        $sales = Transaction::with(['transactionDetails.product', 'user', 'paymentMethod', 'member'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('reports.sales', compact('sales'));
    }

    public function exportSales(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ]);
        $from = $request->from;
        $to = $request->to;
        return Excel::download(new SalesReportExport($from, $to), "sales-{$from}-to-{$to}.xlsx");
    }


    //  transaction summary
    public function transactionSummaryView()
    {
        $transactions = Transaction::with(['user', 'paymentMethod', 'member'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('reports.transaction-summary', compact('transactions'));
    }

    public function exportTransactionSummary(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ]);
        $from = $request->from;
        $to = $request->to;
        return Excel::download(new TransactionSummaryExport($from, $to), "transaction-summary-{$from}-to-{$to}.xlsx");
    }

    public function exportTransactionSummaryPDF(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ]);

        $from = $request->from;
        $to = $request->to;

        $transactions = Transaction::with(['user', 'paymentMethod', 'member'])
            ->whereBetween('created_at', [$from, $to])
            ->get();

        $pdf = FacadePdf::loadView('reports.pdf.transaction-summary-pdf', [
            'transactions' => $transactions,
            'from' => $from,
            'to' => $to
        ]);

        return $pdf->download("transaction-summary-{$from}-to-{$to}.pdf");
    }

    // product sales

    public function productSalesView()
    {
        $productSales = TransactionDetail::with(['product', 'transaction.user'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('reports.product-sales', compact('productSales'));
    }

    public function exportSalesPDF(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ]);

        $from = $request->from;
        $to = $request->to;

        $sales = Transaction::with(['transactionDetails.product', 'user', 'paymentMethod', 'member'])
            ->whereBetween('created_at', [$from, $to])
            ->get();

        $pdf = FacadePdf::loadView('reports.pdf.sales-pdf', [
            'sales' => $sales,
            'from' => $from,
            'to' => $to
        ]);

        return $pdf->download("sales-{$from}-to-{$to}.pdf");
    }

    public function exportProductSales(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ]);
        $from = $request->from;
        $to = $request->to;
        return Excel::download(new ProductSalesReportExport($from, $to), "product-sales-{$from}-to-{$to}.xlsx");
    }

    public function exportProductSalesPDF(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ]);

        $from = $request->from;
        $to = $request->to;

        $productSales = TransactionDetail::with(['product', 'transaction.user'])
            ->whereHas('transaction', function ($q) use ($from, $to) {
                $q->whereBetween('created_at', [$from, $to]);
            })
            ->get();

        $pdf = FacadePdf::loadView('reports.pdf.product-sales-pdf', [
            'productSales' => $productSales,
            'from' => $from,
            'to' => $to
        ]);

        return $pdf->download("product-sales-{$from}-to-{$to}.pdf");
    }

    // transaction information
    public function transactionInfoView()
    {
        $transactions = Transaction::with(['user', 'paymentMethod', 'member'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('reports.transaction-info', compact('transactions'));
    }

    public function exportTransactionInfo(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ]);
        $from = $request->from;
        $to = $request->to;
        return Excel::download(new TransactionInfoExport($from, $to), "transaction-info-{$from}-to-{$to}.xlsx");
    }

    public function exportTransactionInfoPDF(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ]);

        $from = $request->from;
        $to = $request->to;

        $transactions = Transaction::with(['user', 'paymentMethod', 'member'])
            ->whereBetween('created_at', [$from, $to])
            ->get();

        $pdf = FacadePdf::loadView('reports.pdf.transaction-info-pdf', [
            'transactions' => $transactions,
            'from' => $from,
            'to' => $to
        ]);

        return $pdf->download("transaction-info-{$from}-to-{$to}.pdf");
    }
}
