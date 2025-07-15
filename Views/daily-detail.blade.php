@extends('themes.sneat.app')

@section('title', 'Transaction Detail')

@section('content')
<style>
@media print
{    
    nav, footer, .btn-print{
        display: none !important;
    }

    * {background-color: #FFF;box-shadow: none !important;}
}
</style>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Transaction Detail<br>{{date('j F Y', strtotime($date))}}</h4>
                    <button class="btn btn-sm btn-primary" onclick="window.print()">Print</button>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width:50px">No.</th>
                                <th>Cash</th>
                                <th>Description</th>
                                <th>Debt</th>
                                <th>Credit</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $index => $transaction)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$transaction->cash->name}}</td>
                                <td>{{$transaction->description}}</td>
                                <td>{{$transaction->debt_format}}</td>
                                <td>{{$transaction->credit_format}}</td>
                                <td>{{number_format($transaction->debt-$transaction->credit)}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="3">Total</td>
                                <td>{{number_format($transactions->sum('debt'))}}</td>
                                <td>{{number_format($transactions->sum('credit'))}}</td>
                                <td>{{number_format($transactions->sum('debt')-$transactions->sum('credit'))}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
