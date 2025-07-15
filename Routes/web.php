<?php

use App\Modules\Transaction\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function(){
    Route::match(['get','post'], 'transaction/bulk-create', [TransactionController::class, 'bulkCreate'])->name('transaction-bulk-create');

    Route::get('reports/daily-transaction/detail/{date}', [TransactionController::class, 'dailyDetail'])->name('reports.reports/daily-transaction.detail');
    Route::get('reports/monthly-transaction/detail/{date}', [TransactionController::class, 'detail'])->name('reports.reports/monthly-transaction.detail');
});