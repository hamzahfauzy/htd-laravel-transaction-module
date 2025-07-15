<?php

namespace App\Modules\Transaction\Resources\Reports;

use App\Libraries\Abstract\Resource;
use App\Libraries\Components\Button;
use App\Modules\Transaction\Models\Transaction;
use Illuminate\Support\Facades\DB;

class MonthlyResource extends Resource {

    protected static ?string $navigationGroup = 'Reports';
    protected static ?string $navigationLabel = 'Monthly';
    protected static ?string $navigationIcon = 'bx bxs-file-export';
    protected static ?string $slug = 'reports/monthly-transaction';
    protected static ?string $routeGroup = 'reports';
    protected static $deleteRoute = false;
    public static $dataTableClass = 'report-datatable';

    protected static $model = Transaction::class;

    public static function mount()
    {
        static::addScripts([
            asset('modules/transaction/js/report-resource.js')
        ]);
    }

    public static function getModel()
    {
        $date_start = request('filter.date_start', date('Y-m'));
        $date_end = request('filter.date_end', date('Y-m'));
        $model = static::$model::select(
                            DB::raw('DATE_FORMAT(trx_transactions.date, "%Y-%m") date'),
                            DB::raw('FORMAT(COALESCE(SUM(trx_transactions.debt-trx_transactions.credit),0),0) amount'),
                        )
                        ->groupBy(DB::raw('DATE_FORMAT(trx_transactions.date, "%Y-%m")'))
                        ->whereBetween('trx_transactions.date',[$date_start.'-01', date('Y-m-t', strtotime($date_end.'-01'))]);

        return $model;
    }
    
    public static function getPages()
    {
        $resource = static::class;
        return [
            'index' => new \App\Libraries\Abstract\Pages\ListPage($resource),
        ];
    }

    public static function table()
    {
        return [
            'date' => [
                'label' => 'Date',
                '_searchable' => true,
                '_order' => 'date'
            ],
            'amount' => [
                'label' => 'Amount',
                '_searchable' => false,
                '_order' => 'amount'
            ],
            '_action'
        ];
    }

    public static function listHeader()
    {
        return [
            'title' => 'Monthly Report',
            'button' => [
                '<button class="btn btn-primary btn-sm filter-btn" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">Filter</button>
                <!-- Modal -->
                <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="filterModalLabel">Filter</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group mb-2">
                                <label>Month Start</label>
                                <input type="month" class="form-control" id="date_start" name="date_start" value="'.date('Y-m').'">
                            </div>
                            <div class="form-group mb-2">
                                <label>Month End</label>
                                <input type="month" class="form-control" id="date_end" name="date_end" value="'.date('Y-m').'">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary btn-filter">Submit</button>
                        </div>
                    </div>
                </div>
                </div>'
            ]
        ];
    }

    public static function getAction($d)
    {
        $buttons = [
            'view' => (new Button([
                'url' => route('reports.reports/monthly-transaction.detail', ['date' => $d->date]),
                'label' => 'Detail',
                'class' => 'dropdown-item',
                'icon' => 'fas fa-fw fa-eye'
            ]))
            ->routeName(static::getPageRouteName('detail'))
            ->render()
        ];

        return view('libraries.components.actions', compact('buttons'))->render();
    }

}