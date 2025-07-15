<?php

namespace App\Modules\Transaction\Resources\Reports;

use App\Libraries\Abstract\Resource;
use App\Libraries\Components\Button;
use App\Modules\Transaction\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DailyResource extends Resource {

    protected static ?string $navigationGroup = 'Reports';
    protected static ?string $navigationLabel = 'Daily';
    protected static ?string $navigationIcon = 'bx bxs-file-export';
    protected static ?string $slug = 'reports/daily-transaction';
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
        $date_start = request('filter.date_start', date('Y-m-d'));
        $model = static::$model::select(
                            'trx_transactions.*',
                            DB::raw('FORMAT(COALESCE(trx_transactions.debt-trx_transactions.credit,0),0) amount'),
                        )
                        ->where('trx_transactions.date',$date_start);

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
                '_searchable' => [
                    'sp_invoices.created_at',
                ],
                '_order' => 'date'
            ],
            'cash.name' => [
                'label' => 'Cash',
                '_searchable' => false,
                '_order' => false
            ],
            'description' => [
                'label' => 'Description',
                '_searchable' => true,
                '_order' => false
            ],
            'amount' => [
                'label' => 'Amount',
                '_searchable' => false,
                '_order' => 'amount'
            ],
            // '_action'
        ];
    }

    public static function listHeader()
    {
        return [
            'title' => 'Daily Report',
            'button' => [
                '<button class="btn btn-primary btn-sm filter-btn" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">Filter</button>
                <a href="javascript:void(0)" class="btn btn-primary btn-sm print-btn">Print</a>
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
                                <label>Date</label>
                                <input type="date" class="form-control" id="date_start" name="date_start" value="'.date('Y-m-d').'">
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

    // public static function getAction($d)
    // {
    //     $buttons = [
    //         'view' => (new Button([
    //             'url' => route('reports.reports/daily-transaction.detail', ['date' => $d->date]),
    //             'label' => 'Detail',
    //             'class' => 'dropdown-item',
    //             'icon' => 'fas fa-fw fa-eye'
    //         ]))
    //         ->routeName(static::getPageRouteName('detail'))
    //         ->render()
    //     ];

    //     return view('libraries.components.actions', compact('buttons'))->render();
    // }

}