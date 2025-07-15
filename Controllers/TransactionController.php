<?php

namespace App\Modules\Transaction\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Transaction\Models\Cash;
use App\Modules\Transaction\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller 
{

    public function bulkCreate(Request $request)
    {
        if($request->isMethod('POST'))
        {
            $cash_id = $request->cash_id;
            $type    = $request->transaction_type;
            $description = $request->description;

            $lines = explode("\n", $description);
            $results = [];

            foreach ($lines as $line) {
                // Ambil bagian pertama (tanggal), kedua (nominal), sisanya adalah deskripsi
                preg_match('/^(\d{2}-\d{2}-\d{4})\s+(\d+)\s+(.*)$/', $line, $matches);
                if ($matches) {
                    $results[] = [
                        'date' => \Carbon\Carbon::createFromFormat('d-m-Y',$matches[1])->format('Y-m-d'),
                        $type => (int)$matches[2],
                        'description' => $matches[3],
                        'cash_id' => $cash_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            Transaction::insert($results);
            return redirect()->route('transactions.transactions/transaction.index');
        }

        $cash = Cash::pluck('name','id');
        return view('transaction::bulk-create', [
            'fields' => [
                'cash_id' => [
                    'label' => 'Cash',
                    'type'  => 'select2',
                    'options' => $cash,
                    'placeholder' => 'Choose'
                ],
                'transaction_type' => [
                    'label' => 'Type',
                    'type'  => 'select2',
                    'options' => [
                        'debt' => 'Debt',
                        'credit' => 'Credit',
                    ],
                    'placeholder' => 'Choose'
                ],
                'description' => [
                    'label' => 'Description',
                    'type' => 'textarea',
                    'placeholder' => 'Transaction description format : [date] [amount] [description]'
                ]
            ],
            'data' => [],
            'page' => null
        ]);
    }

    public function detail($date)
    {
        $transactions = Transaction::where(DB::raw('DATE_FORMAT(date,"%Y-%m")'),$date)->orderBy('date')->get();

        return view('transaction::monthly-detail', compact('transactions', 'date'));
    }

    public function dailyDetail($date)
    {
        $transactions = Transaction::where('date',$date)->orderBy('date')->get();

        return view('transaction::daily-detail', compact('transactions', 'date'));
    }

}