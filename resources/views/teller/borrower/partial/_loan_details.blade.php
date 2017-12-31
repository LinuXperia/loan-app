<div class="row">
    <div class="col-6 col-lg-3">
        <div class="card">
            <div class="card-body p-0 clearfix">
                <i class="fa fa-bank bg-primary p-4 font-2xl mr-3 float-left"></i>
                <div class="h5 text-primary mb-0 pt-3">KSH. {{ number_format($totalLoan, 2) }}</div>
                <div class="text-muted text-uppercase font-weight-bold font-xs">Total Loan</div>
            </div>
        </div>
    </div>
    <!--/.col-->

    <div class="col-6 col-lg-3">
        <div class="card">
            <div class="card-body p-0 clearfix">
                <i class="fa fa-line-chart bg-secondary p-4 font-2xl mr-3 float-left"></i>
                <div class="h5 text-secondary mb-0 pt-3">KSH. {{ number_format($totalInterest, 2) }}</div>
                <div class="text-muted text-uppercase font-weight-bold font-xs">Total Interest</div>
            </div>
        </div>
    </div>
    <!--/.col-->

    <div class="col-6 col-lg-3">
        <div class="card">
            <div class="card-body p-0 clearfix">
                <i class="fa fa-plus-square-o bg-warning p-4 font-2xl mr-3 float-left"></i>
                <div class="h5 text-warning mb-0 pt-3">KSH. {{ number_format($totalPayment, 2) }}</div>
                <div class="text-muted text-uppercase font-weight-bold font-xs">Total Payment</div>
            </div>
        </div>
    </div>
    <!--/.col-->

    <div class="col-6 col-lg-3">
        <div class="card">
            <div class="card-body p-0 clearfix">
                <i class="fa fa-money bg-danger p-4 font-2xl mr-3 float-left"></i>
                <div class="h5 text-danger mb-0 pt-3">KSH. {{ number_format($totalBalance, 2) }}</div>
                <div class="text-muted text-uppercase font-weight-bold font-xs">Total Balance</div>
            </div>
        </div>
    </div>
    <!--/.col-->
</div>
<!--/.row-->