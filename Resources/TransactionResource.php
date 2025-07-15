<?php

namespace App\Modules\Transaction\Resources;

use App\Libraries\Abstract\Resource;
use App\Libraries\Components\Button;
use App\Modules\Transaction\Models\Cash;
use App\Modules\Transaction\Models\Transaction;

class TransactionResource extends Resource
{

    protected static ?string $navigationGroup = 'Transactions';
    protected static ?string $navigationLabel = 'Transaction';
    protected static ?string $navigationIcon = 'bx bx-category';
    protected static ?string $slug = 'transactions/transaction';
    protected static ?string $routeGroup = 'transactions';

    protected static $model = Transaction::class;
    
    public static function getModel()
    {
        $model = new static::$model();

        $date = [
            'start' => request('filter.date_start', false),
            'end' => request('filter.date_end', false),
        ];

        $cash = request('filter.cash_id', false);

        if($date['start'] && $date['end'])
        {
            $model = $model->whereBetween('date', [$date['start'], $date['end']]);
        }

        if($cash)
        {
            $model = $model->where('cash_id', $cash);
        }

        return $model;
    }

    public static function table()
    {
        return [
            'date_format' => [
                'label' => 'Date',
                '_searchable' => 'date',
                '_order'=>'date'
            ],
            'description' => [
                'label' => 'Description',
                '_searchable' => true
            ],
            'debt_format' => [
                'label' => 'Debt',
                '_searchable' => 'debt',
                '_order' => 'debt'
            ],
            'credit_format' => [
                'label' => 'Credit',
                '_searchable' => 'credit',
                '_order' => 'credit'
            ],
            'cash.name' => [
                'label' => 'Cash',
                '_searchable' => true
            ],
            'created_at' => [
                'label' => 'Created At',
            ],
            '_action'
        ];
    }

    public static function form()
    {
        $cash = Cash::pluck('name','id');
        return [
            'Form Transaction' => [
                'date' => [
                    'label' => 'Date',
                    'type' => 'date',
                    'placeholder' => 'Date'
                ],
                'description' => [
                    'label' => 'Description',
                    'type' => 'textarea',
                    'placeholder' => 'Description'
                ],
                'debt' => [
                    'label' => 'Debt',
                    'type' => 'number',
                    'placeholder' => 'Debt'
                ],
                'credit' => [
                    'label' => 'Credit',
                    'type' => 'number',
                    'placeholder' => 'Credit'
                ],
                'cash_id' => [
                    'label' => 'Cash',
                    'type' => 'select2',
                    'options' => $cash,
                    'placeholder' => 'Choose'
                ],
            ]
        ];
    }

    public static function detail()
    {
        return [
            'Detail' => [
                'date' => 'Date',
                'description' => 'Description',
                'debt' => 'Debt',
                'credit' => 'Credit',
                'cash.name' => 'Cash',
                'created_at' => 'Created At',
            ],
        ];
    }

    public static function createRules()
    {
        return [
            'date' => 'required',
            'description' => 'required',
            'debt' => 'nullable',
            'credit' => 'nullable',
            'cash_id' => 'required',
        ];
    }
    
    public static function updateRules()
    {
        return [
            'date' => 'required',
            'description' => 'required',
            'debt' => 'nullable',
            'credit' => 'nullable',
            'cash_id' => 'required',
        ];
    }

    public static function listHeader()
    {
        return [
            'title' => static::$navigationLabel . ' List',
            'button' => [
                (new Button([
                    'url' => static::getPageRoute('create'),
                    'class' => 'btn btn-sm btn-primary',
                    'label' => 'Create',
                    'icon' => 'fas fa-fw fa-plus'
                ]))
                    ->routeName(static::getPageRouteName('create'))
                    ->render(),
                (new Button([
                    'url' => route('transaction-bulk-create'),
                    'class' => 'btn btn-sm btn-primary',
                    'label' => 'Bulk Create',
                    'icon' => 'fas fa-fw fa-plus'
                ]))
                    ->routeName('transaction-bulk-create')
                    ->render()
            ]
        ];
    }
}
