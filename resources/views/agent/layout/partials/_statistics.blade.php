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
                      <small>Today's Total Loan</small>
                    </span>
                    <span class="float-right">
                      <small>Ksh. {{ number_format($totalLoanAmount, 2) }}</small>
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
                      <small>Today's Total Payments</small>
                    </span>
                    <span class="float-right">
                      <small>ksh. {{ number_format($totalPaymentAmount, 2) }}</small>
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
                      <small>Total Loans Issued</small>
                    </span>
                    <span class="float-right">
                      <small>{{ $totalLoansIssued }}</small>
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
                      <small> Total Payment Received</small>
                    </span>
                    <span class="float-right">
                      <small>{{ $totalPaymentsReceived }}</small>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!--/.col-->

</div>
<!--/.row-->