<?php

namespace App\Modules\Transaction\Services;

use App\Modules\Transaction\Models\Cash;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    static function statistic()
    {
        $today = \Carbon\Carbon::today();
        $startOfMonth = \Carbon\Carbon::now()->startOfMonth();

        // num of cash account
        // balance
        // cash in, cash out
        $cash = Cash::count();
        $transaction = DB::table('trx_transactions')
            ->selectRaw("
                SUM(debt-credit) AS `balance`,
                SUM(debt) AS `cash_in`,
                SUM(credit) AS `cash_out`
            ")
            ->first();

        return view('transaction::dashboard.statistic', compact('cash','transaction'));
    }
}