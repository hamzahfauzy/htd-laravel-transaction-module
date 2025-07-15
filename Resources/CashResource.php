<?php

namespace App\Modules\Transaction\Resources;

use App\Libraries\Abstract\Resource;
use App\Modules\Transaction\Models\Cash;

class CashResource extends Resource
{

    protected static ?string $navigationGroup = 'Transactions';
    protected static ?string $navigationLabel = 'Cash';
    protected static ?string $navigationIcon = 'bx bx-category';
    protected static ?string $slug = 'transactions/cash';
    protected static ?string $routeGroup = 'transactions';

    protected static $model = Cash::class;

    public static function table()
    {
        return [
            'name' => [
                'label' => 'Name',
                '_searchable' => true
            ],
            'debt' => [
                'label' => 'Debt',
                '_searchable' => false
            ],
            'credit' => [
                'label' => 'Credit',
                '_searchable' => false
            ],
            'balance' => [
                'label' => 'Balance',
                '_searchable' => false
            ],
            'created_at' => [
                'label' => 'Created At',
            ],
            '_action'
        ];
    }

    public static function form()
    {
        return [
            'Form Cash' => [
                'name' => [
                    'label' => 'Name',
                    'type' => 'text',
                    'placeholder' => 'Input '
                ],
            ]
        ];
    }

    public static function detail()
    {
        return [
            'Detail' => [
                'name' => 'Name',
                'created_at' => 'Tanggal Dibuat',
            ],
        ];
    }

    public static function createRules()
    {
        return [
            'name' => 'required',
        ];
    }
    
    public static function updateRules()
    {
        return [
            'name' => 'required',
        ];
    }
}
