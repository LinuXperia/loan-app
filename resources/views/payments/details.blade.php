@extends(Auth()->user()->hasRole('admin') ? 'admin/layouts/main': 'agent/layout/main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Loan Details
                </div>
                <div class="card-body">
                    <div class="row loan-details">
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark" style="margin-top: 5%"><Strong class="title">LOAN REFERENCE NO: </Strong> </h5>
                                </div>
                                <div class="col-sm-8">
                                    <div class="alert alert-warning text-center"><a href="{{ route('customer.loanDetails', ['user_id' => $loan->user_id, 'loan_id' =>$loan->id]) }}"><strong>{{ $loan->reference_no }}</strong></a></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark text-center" style="margin-top: 15%"><Strong class="title">LOAN TOTAL: </Strong> </h5>
                                </div>
                                <div class="col-sm-8">
                                    <div class="alert alert-warning text-center">KSH: {{ number_format($loan->amount_to_pay,2) }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark text-center" style="margin-top: 15%"><Strong class="title">BALANCE BEFORE: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <div class="alert alert-warning text-center"> KSH: {{ number_format($loan->balance, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Payment Details
                </div>
                <div class="card-body">
                    <div class="row loan-details">
                        <div class="col-sm-5">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h5 class="text-dark" style="margin-top: 5%"><Strong class="title">PAYMENT REFERENCE NO: </Strong> </h5>

                                </div>
                                <div class="col-sm-9">
                                    <div class="alert alert-info text-center">{{ $payment->reference_no }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark text-center" style="margin-top: 15%"><Strong class="title">PAYED ON: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <div class="alert alert-info text-center">{{ $payment->created_at->toFormattedDateString() }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark text-center" style="margin-top: 15%"><Strong class="title">AMOUNT PAID: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                        <div class="alert alert-info text-center">KSH: {{ number_format($payment->amount, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row loan-details">
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark" style="margin-top: 5%"><Strong class="title">BALANCE AFTER: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <div class="alert alert-info text-center">KSH: {{ number_format(($loan->balance - $payment->amount), 2) }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark text-center" style="margin-top: 15%"><Strong class="title">RECEIVED BY </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <div class="alert alert-info text-center">{{ $payment->received_by }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark text-center" style="margin-top: 15%"><Strong class="title">PAYMENT MODE: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <div class="alert alert-info text-center">
                                        {{ $payment->payment_mode }} |
                                        <strong>
                                            @if($payment->payment_mode =='mpesa')
                                                {{ $payment->mpesa_no }}
                                            @elseif($payment->payment_mode =='cheque')
                                                {{ $payment->cheque_no }}
                                            @endif
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row loan-details">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-2">
                                    <h5 class="text-dark" style="margin-top: 5%"><Strong class="title">REMARKS: </Strong> </h5>

                                </div>
                                <div class="col-sm-10">
                                    <div class="alert alert-light">{{ $payment->description }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row loan-details">
                        <div class="col-sm-4 offset-4">
                            <a href="{{ route('download.loan.payment.details', ['id' => $payment->id]) }}"  class="btn btn-outline-secondary btn-block">Download Loan Payment Details</a>
                        </div>
                    </div>

                    @role('admin')
                    <div class="row loan-details">
                        <div class="col-sm-12 col-md-12">
                            <div class="card bg-default text-center">
                                <approve-payment payment-details = "{{ $payment }}"></approve-payment>
                            </div>
                        </div>
                    </div>
                    @endrole
                </div>
            </div>
        </div>
    </div>
@endsection