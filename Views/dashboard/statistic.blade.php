<div class="row">
    <div class="col-12 col-md-3 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="card-title mb-6">
                <h5 class="text-nowrap mb-1">Cash Account</h5>
                </div>
                <div class="mt-sm-auto">
                <span class="text-success text-nowrap fw-medium"></span>
                <h3 class="mb-0">{{number_format($cash)}}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-md-3 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="card-title mb-6">
                <h5 class="text-nowrap mb-1">Balance</h5>
                </div>
                <div class="mt-sm-auto">
                <span class="text-success text-nowrap fw-medium"></span>
                <h3 class="mb-0">{{number_format($transaction->balance)}}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-md-3 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="card-title mb-6">
                <h5 class="text-nowrap mb-1">Debt</h5>
                </div>
                <div class="mt-sm-auto">
                <span class="text-success text-nowrap fw-medium"></span>
                <h3 class="mb-0">{{number_format($transaction->cash_in)}}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-md-3 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="card-title mb-6">
                <h5 class="text-nowrap mb-1">Credit</h5>
                </div>
                <div class="mt-sm-auto">
                <span class="text-success text-nowrap fw-medium"></span>
                <h3 class="mb-0">{{number_format($transaction->cash_out)}}</h3>
                </div>
            </div>
        </div>
    </div>
</div>