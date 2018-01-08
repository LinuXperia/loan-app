<div class="row">
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-header bg-primary">
                <div class="font-weight-bold">
                        <span>
                            @php
                                echo strtoupper(date('l, jS  F Y'));
                            @endphp
                        </span>
                </div>
                <div>
                    <span>
                      <small>Today's Total Amount</small>
                    </span>
                    <span class="float-right">
                      <small>ksh. {{ number_format($dailyLoan, 2) }}</small>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-header bg-danger">
                <div class="font-weight-bold">
                    <span>
                        @php
                            echo strtoupper(date('l, jS  F Y'));
                        @endphp
                    </span>
                </div>
                <div>
                    <span>
                      <small>Total Payment</small>
                    </span>
                    <span class="float-right">
                      <small>ksh. {{ number_format($dailyPayment, 2) }}</small>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!--/.col-->
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-header bg-success">
                <div class="font-weight-bold">
                    <span>
                         @php
                             echo strtoupper(date('l, jS  F Y'));
                         @endphp
                    </span>
                </div>
                <div>
                    <span>
                      <small>Approved Loans</small>
                    </span>
                    <span class="float-right">
                      <small>{{ $approvedLoans }}</small>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!--/.col-->
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-header bg-warning">
                <div class="font-weight-bold">
                    <span>
                        @php
                            echo strtoupper(date('l, jS  F Y'));
                        @endphp
                    </span>
                </div>
                <div>
                    <span>
                      <small>Approved Payments</small>
                    </span>
                    <span class="float-right">
                      <small>{{ $approvedPayments }}</small>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!--/.col-->

</div>
<!--/.row-->