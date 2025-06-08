<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Member;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    private function getMonthlyRevenue()
    {
        $year = now()->year;

        $monthlyRevenue = Transaction::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->whereYear('created_at', $year)
            ->where('status', 'paid')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $monthlyExpenses = Expense::selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->whereYear('date', $year)
            ->where('status', 'approved')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $revenueData = [];
        $expenseData = [];

        for ($month = 1; $month <= 12; $month++) {
            $revenueData[] = $monthlyRevenue[$month] ?? 0;
            $expenseData[] = $monthlyExpenses[$month] ?? 0;
        }

        $totalRevenue = array_sum($revenueData);
        $totalExpenses = array_sum($expenseData);

        return [
            'revenue' => $revenueData,
            'expenses' => $expenseData,
            'totalRevenue' => $totalRevenue,
            'totalExpenses' => $totalExpenses
        ];
    }


    public function index()
    {
        $totalProducts = Product::count();
        $totalCustomers = Member::count();
        $todaysOrders = Transaction::whereDate('created_at', now())->count();
        $todaysSales = Transaction::whereDate('created_at', now())->sum('total_amount');

        $recentOrders = Transaction::with(['user', 'member', 'transactionDetails.product'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $transactionsByPaymentMethod = $this->getTransactionsByPaymentMethod();

        $topCustomers = $this->getTopCustomers();

        $topSellingProducts = $this->getTopSellingProducts();

        $revenueData = $this->getMonthlyRevenue();

        return view('dashboard.index', compact(
            'totalProducts',
            'totalCustomers',
            'todaysOrders',
            'todaysSales',
            'recentOrders',
            'transactionsByPaymentMethod',
            'topCustomers',
            'topSellingProducts',
            'revenueData'
        ));
    }

    // recent
    private function getTransactionsByPaymentMethod()
    {
        $paymentMethods = PaymentMethod::select('payment_methods.*')
            ->addSelect(DB::raw('COUNT(transactions.id) as transaction_count'))
            ->addSelect(DB::raw('SUM(transactions.total_amount) as total_amount'))
            ->leftJoin('transactions', 'payment_methods.id', '=', 'transactions.payment_method_id')
            ->groupBy('payment_methods.id')
            ->orderBy('transaction_count', 'desc')
            ->where('payment_methods.is_active', 1)
            ->take(6)
            ->get();

        $result = [];

        foreach ($paymentMethods as $method) {
            $recentTransaction = Transaction::where('payment_method_id', $method->id)
                ->with('member')
                ->orderBy('created_at', 'desc')
                ->first();

                if ($recentTransaction) {
                $result[] = [
                    'payment_method' => $method,
                    'transaction_count' => $method->transaction_count,
                    'total_amount' => $method->total_amount,
                    'recent_transaction' => $recentTransaction,
                    'reference' => $recentTransaction->member ? $recentTransaction->member->name : 'Walk-in Customer',
                ];
            }
        }

        return $result;
    }

    private function getTopCustomers()
    {
        $topCustomers = Member::select(
            'members.id',
            'members.name',
            'members.phone_number',
            DB::raw('COUNT(transactions.id) as order_count'),
            DB::raw('SUM(transactions.total_amount) as total_spent')
        )
            ->leftJoin('transactions', 'members.id', '=', 'transactions.member_id')
            ->groupBy('members.id', 'members.name', 'members.phone_number')
            ->orderBy('order_count', 'desc')
            ->take(5)
            ->get();

        return $topCustomers;
    }

   
    private function getTopSellingProducts()
    {
        $topProducts = DB::table('transaction_details')
            ->select(
                'products.id',
                'products.name',
                'products.image',
                'products.price',
                'products.is_discount',
                'products.discount',
                'products.discount_type',
                'categories.name as category_name',
                DB::raw('SUM(transaction_details.quantity) as total_sold'),
                DB::raw('COUNT(DISTINCT transactions.id) as order_count')
            )
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->groupBy(
                'products.id',
                'products.name',
                'products.image',
                'products.price',
                'products.is_discount',
                'products.discount',
                'products.discount_type',
                'categories.name'
            )
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        return $topProducts;
    }
}
