<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BusinessSettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ComponentspageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CryptocurrencyController;
use App\Http\Controllers\DiningTableController;
use App\Http\Controllers\ExpenseCategoriesController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TransactionController;
use App\Livewire\TransactionPayment;

// authentication (guest)
Route::middleware(['guest'],)->controller(AuthenticationController::class)->group(function () {
    Route::get('/sign-in', 'signin')->name('login');
    Route::post('/sign-in', 'actionSignIn')->name('actionSignIn');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/logout', [AuthenticationController::class, 'logout'])->name('logout');
});



Route::middleware(['setUserInactiveOnSessionExpire'])->group(function () {

    Route::middleware(['auth', 'multi_user'])->group(function () {
        Route::get('/add-user', [UsersController::class, 'addUser'])->name('addUser');
        Route::post('/store-user', [UsersController::class, 'storeUser'])->name('storeUser');
        Route::get('/edit-user/{id}', [UsersController::class, 'editUser'])->name('editUser');
        Route::put('/update-user/{id}', [UsersController::class, 'updateUser'])->name('updateUser');
        Route::get('/view-user/{id}', [UsersController::class, 'viewUserProfile'])->name('viewUserProfile');
        Route::delete('/delete-user/{id}', [UsersController::class, 'deleteUser'])->name('deleteUser');
    });

    // just auth
    Route::middleware(['auth'])->group(function () {
        Route::get('/receipt/{transaction}', [ReceiptController::class, 'print'])->name('receipt.print');
    });

    // reports
    Route::middleware(['auth', 'multi_user'])->prefix('reports')->controller(ReportController::class)->group(function () {
        Route::get('/expense', 'expenseView')->name('reports.expenses');
        Route::get('/expense/export', 'exportExpense')->name('reports.expenses.export');
        Route::get('/expense/export-pdf', 'exportExpensePDF')->name('reports.expenses.export-pdf');

        Route::get('/sales', 'salesView')->name('reports.sales');
        Route::get('/sales/export', 'exportSales')->name('reports.sales.export');
        Route::get('/sales/export-pdf', 'exportSalesPDF')->name('reports.sales.export-pdf');


        Route::get('/transaction-summary', 'transactionSummaryView')->name('reports.transaction-summary');
        Route::get('/transaction-summary/export', 'exportTransactionSummary')->name('reports.transaction-summary.export');
        Route::get('/transaction-summary/export-pdf', 'exportTransactionSummaryPDF')->name('reports.transaction-summary.export-pdf');


        Route::get('/product-sales', 'productSalesView')->name('reports.product-sales');
        Route::get('/product-sales/export', 'exportProductSales')->name('reports.product-sales.export');
        Route::get('/product-sales/export-pdf', 'exportProductSalesPDF')->name('reports.product-sales.export-pdf');


        Route::get('/transaction-info', 'transactionInfoView')->name('reports.transaction-info');
        Route::get('/transaction-info/export', 'exportTransactionInfo')->name('reports.transaction-info.export');
        Route::get('/transaction-info/export-pdf', 'exportTransactionInfoPDF')->name('reports.transaction-info.export-pdf');
    });


    // users
    Route::middleware(['auth'])->prefix('users')->group(function () {
        Route::controller(UsersController::class)->group(function () {
            Route::get('/add-user', 'addUser')->name('addUser')->middleware('multi_user');
            Route::get('/users-list', 'usersList')->name('usersList')->middleware('multi_user');
            Route::get('/view-profile', 'viewProfile')->name('viewProfile');
            Route::post('/change-password', 'changePassword')->name('changePassword');
            Route::delete('/users/{id}', 'deleteUser')->name('deleteUser');
        });
    });

    // category
    Route::middleware(['auth', 'multi_user'])->prefix('category')->controller(CategoryController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/create', 'create')->name('newCategory');
        Route::post('/create', 'store')->name('actionNewCategory');
        Route::get('/edit/{id}', 'edit')->name('editCategory');
        Route::put('/edit/{id}', 'update')->name('actionEditCategory');
        Route::delete('/delete/{id}', 'destroy')->name('actionDeleteCategory');

        // search
        Route::get('/categories/search', 'search')->name('categories.search');
    });



    // product
    Route::middleware(['auth', 'multi_user'])->prefix('product')->controller(ProductController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/create', 'create')->name('newProduct');
        Route::post('/create', 'store')->name('actionNewProduct');
        Route::get('/edit/{id}', 'edit')->name('editProduct');
        Route::put('/edit/{id}', 'update')->name('actionEditProduct');
        Route::put('/add-stock/{id}', 'addStockProduct')->name('actionAddStockProduct');
        Route::delete('/delete/{id}', 'destroy')->name('actionDeleteProduct');


        // barcode
        Route::get('/{id}/print-barcode', [ProductController::class, 'printBarcode'])->name('product.print-barcode');

        // export import csv
        Route::get('/export-csv', 'exportCsv')->name('product.export-csv');
        Route::post('/import-csv', 'importCsv')->name('product.import-csv');
        Route::get('/download-template', 'downloadTemplate')->name('product.download-template');
    });


    // product  
    Route::middleware(['auth'])->prefix('payment-method')->controller(PaymentMethodController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/create', 'create')->name('newPaymentMethod');
        Route::post('/create', 'store')->name('actionNewPaymentMethod');
        Route::get('/edit/{id}', 'edit')->name('editPaymentMethod');
        Route::put('/edit/{id}', 'update')->name('actionEditPaymentMethod');
        Route::delete('/delete/{id}', 'destroy')->name('actionDeletePaymentMethod');
    });


    Route::middleware(['auth'])->prefix('member')->controller(MemberController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/create', 'create')->name('newMember');
        Route::post('/create', 'store')->name('actionNewMember');
        Route::get('/edit/{id}', 'edit')->name('editMember');
        Route::put('/edit/{id}', 'update')->name('actionEditMember');
        // hanya user yang bukan operator yang bisa mengakses delete
        Route::middleware(['multi_user'])->group(function () {
            Route::delete('/delete/{id}', 'destroy')->name('actionDeleteMember');
        });
    });



    // expense
    Route::middleware(['auth'])->prefix('expense')->controller(ExpenseController::class)->group(function () {
        Route::get('/', 'index');
        Route::middleware(['multi_user'])->group(function () {
            Route::get('/edit/{id}', 'edit')->name('editExpense');
            Route::put('/edit/{id}', 'update')->name('actionEditExpense');
        });
        Route::get('/create', 'create')->name('newExpense');
        Route::post('/create', 'store')->name('actionNewExpense');
        Route::delete('/delete/{id}', 'destroy')->name('actionDeleteExpense');

        Route::post('/print', 'print')->name('printExpenses');
        Route::post('/import', 'import')->name('importExpenses');
        Route::post('/export', 'export')->name('exportExpenses');
    });

    Route::middleware(['auth'])->prefix('expense')->controller(ExpenseController::class)->group(function () {
        Route::post('/{id}/approve', [ExpenseController::class, 'approve'])->name('expense.approve');
        Route::post('/{id}/reject', [ExpenseController::class, 'reject'])->name('expense.reject');
    });

    // expense categories
    Route::middleware(['auth', 'multi_user'])->prefix('expense-categories')->controller(ExpenseCategoriesController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/create', 'create')->name('newExpenseCategory');
        Route::post('/create', 'store')->name('actionNewExpenseCategory');
        Route::get('/edit/{id}', 'edit')->name('editExpenseCategory');
        Route::put('/edit/{id}', 'update')->name('actionEditExpenseCategory');
        Route::delete('/delete/{id}', 'destroy')->name('actionDeleteExpenseCategory');
    });

    // order
    Route::middleware(['auth'])->group(function () {
        Route::get('/order', [OrderController::class, 'index']);
    });

    // transaction
    Route::middleware(['auth'])->group(function () {
        Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction');
        Route::get('/transaction/{id}/payment', [TransactionController::class, 'show'])->name('transaction.payment');
        Route::get('/invoice/{id}', [TransactionController::class, 'showInvoice'])->name('transaction.invoice');
    });

    // reservasi
    Route::middleware(['auth'])->prefix('reservations')->controller(ReservationController::class)->group(function () {
        Route::get('/', 'index')->name('reservations.index');
        Route::get('/create', 'create')->name('reservations.create');
        Route::post('/create', 'store')->name('reservations.store');
        Route::get('/edit/{id}', 'edit')->name('reservations.edit');
        // Route::put('/{id}', 'update')->name('actionUpdateReservation');
        Route::delete('/delete/{id}', 'delete')->name('reservations.destroy');
        Route::resource('reservations', ReservationController::class);
    });

    // tables
    Route::middleware(['auth'])->prefix('tables')->controller(DiningTableController::class)->group(function () {
        Route::get('/', 'index')->name('tables');
        Route::get('/create', 'create')->name('newDiningTable');
        Route::post('/create', 'store')->name('actionNewDiningTable');
        Route::get('/edit/{id}', 'edit')->name('actionEditDiningTable');
        Route::put('/edit/{id}', 'update')->name('actionUpdateDiningTable');
        Route::delete('/delete/{id}', 'destroy')->name('actionDeleteDiningTable');
    });

    // settings
    Route::middleware(['auth', 'multi_user'])->prefix('settings')->group(function () {
        Route::controller(BusinessSettingController::class)->group(function () {
            Route::get('/business', 'index')->name('business.settings');
            Route::post('/business', 'update')->name('business.update');
        });
    });

    // users
    Route::middleware(['auth', 'multi_user'])->prefix('users')->group(function () {
        Route::controller(UsersController::class)->group(function () {
            Route::get('/add-user', 'addUser')->name('addUser');
        });
    });
});
