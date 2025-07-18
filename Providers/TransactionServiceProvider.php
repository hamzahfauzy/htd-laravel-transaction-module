<?php

namespace App\Modules\Transaction\Providers;

use App\Libraries\Dashboard;
use Illuminate\Support\ServiceProvider;

class TransactionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Databases/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../Views', 'transaction');

        Dashboard::add(\App\Modules\Transaction\Services\DashboardService::statistic());
    }
}
