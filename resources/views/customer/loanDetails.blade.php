@extends(Auth()->user()->hasRole('admin') ? 'admin/layouts/main': 'agent/layout/main')

@section('content')
    @include('customer.partial._loan_details')

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
                                    <h5 class="text-dark text-center" style="margin-top: 15%"><Strong class="title">REFERENCE NO: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <div class="alert alert-info text-center">
                                        {{ $loan->reference_no }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark text-center" style="margin-top: 15%"><Strong class="title">ISSUED BY: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <div class="alert alert-info text-center">{{  $loan->issued_by ?  $loan->issued_by : '' }}</div>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark text-center" style="margin-top: 15%"><Strong class="title">APPROVED BY: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    @if($loan->approved !== null && $loan->approved_by !== '')
                                        <div class="alert alert-success text-center">{{ $loan->approved_by }}</div>

                                    @elseif($loan->approved === null)
                                        <div class="alert alert-danger text-center">Loan Not Approved</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row loan-details">
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark" style="margin-top: 20%"><Strong class="title">APPROVED: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">

                                    @if($loan->approved !== null && $loan->approved == true)

                                        <div class="alert alert-success text-center">Loan Approved</div>

                                    @elseif($loan->approved !== null && $loan->approved == false)

                                        <div class="alert alert-warning text-center">Loan Declined</div>


                                    @elseif($loan->approved === null)

                                        <div class="alert alert-danger text-center">Loan Not Approved.</div>

                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark text-center" style="margin-top: 15%"><Strong class="title">APPROVED DATE: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    @if($loan->approved !== null && $loan->approved_date !== '')
                                        <div class="alert alert-success text-center">{{ $loan->approved_date }}</div>

                                    @elseif($loan->approved === null)
                                        <div class="alert alert-danger text-center">Loan Not Approved</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark text-center" style="margin-top: 15%"><Strong class="title">PAID AMOUNT: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <div class="alert alert-success text-center">KSH: {{ number_format(($loan->amount_to_pay - $loan->loanBalance), 2) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row loan-details">
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark text-center" style="margin-top: 15%"><Strong class="title">ISSUED ON: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <div class="alert alert-info text-center">
                                        {{ $loan->created_at->toFormattedDateString() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark" style="margin-top: 20%"><Strong class="title">STATUS: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    @if($loan->status == 'paid')
                                        <div class="alert alert-success text-center">Loan Paid. <strong>Balance: KSH: 0.00</strong></div>

                                    @elseif($loan->status == 'unpaid')
                                        <div class="alert alert-warning text-center">Loan Not Paid. </div>

                                    @elseif($loan->status == 'partial')
                                        <div class="alert alert-info text-center">Loan Paid Partially.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark text-center" style="margin-top: 15%"><Strong class="title">BALANCE: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <div class="alert alert-info text-center">KSH: {{ number_format($loan->loanBalance, 2) }}</div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="row loan-details">
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark"><Strong class="title">customer: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <h5  class="content">{{ $user->sname .' ' . $user->fname . ' ' . $user->lname}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark"><Strong class="title">EMAIL: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <h5  class="content">{{ $user->email }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark"><Strong class="title">PHONE NO. </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <h5  class="content">{{ $user->mobile }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row loan-details">

                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark text-center"><Strong class="title">AMOUNT BORROWED </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <h5  class="content"> KSH. {{ $loan->amount_borrowed ?  number_format($loan->amount_borrowed, 2) : '0.00' }}</h5>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark text-center"><Strong class="title">AMOUNT TO PAY: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <h5  class="content">KSH: {{  $loan->amount_to_pay ?  number_format($loan->amount_to_pay, 2) : ''}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark text-center"><Strong class="title">INTEREST: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <h5  class="content">KSH: {{  number_format(($loan->amount_to_pay - $loan->amount_borrowed), 2) }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row loan-details">
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark"><Strong class="title">DURATION: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <h5  class="content">{{  $loan->duration ? $loan->duration : '' }} Months</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark text-center"><Strong class="title">PAYMENT DATE: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <h5  class="content"> {{ $loan->payment_date ?  $loan->payment_date : '' }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark text-center"><Strong class="title">INTEREST RATE: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <h5  class="content">{{  $loan->interest_rate ?  number_format($loan->interest_rate, 1) : '0.0'}} %</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row loan-details">
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark"><Strong class="title">LOAN TYPE: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <h5  class="content">{{  $loan->loan_type ? $loan->loan_type : '' }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark"><Strong class="title">LEGAL FEE: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <h5  class="content">KSH. {{  $loan->legal_fee ? number_format($loan->legal_fee, 2) : '0.00' }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark text-center"><Strong class="title">PROCESSING FEE: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <h5  class="content"> KSH. {{ $loan->processing_fee ?  number_format($loan->processing_fee, 2) : '0.00' }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row loan-details">
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark"><Strong class="title">KRA FEE: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <h5  class="content">KSH. {{  $loan->kra ?  number_format($loan->kra, 2) : '0.00'}} </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark text-center"><Strong class="title">CAR TRACK INSTALLATION: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <h5  class="content">KSH. {{  $loan->car_track_installation ? number_format($loan->car_track_installation, 2) : '0.00' }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark text-center"><Strong class="title">CAR TRACK MAINTENANCE FEE: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <h5  class="content"> KSH. {{ $loan->car_track_maintenance ?  number_format($loan->car_track_maintenance, 2) : '0.00' }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row loan-details">
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark text-center"><Strong class="title">LOGISTICS FEE: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <h5  class="content">KSH. {{  $loan->logistics ?  number_format($loan->logistics, 2) : '0.00'}} </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark"><Strong class="title">MV FEE: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <h5  class="content">KSH. {{  $loan->mv ? number_format($loan->mv, 2) : '0.00' }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5 class="text-dark text-center"><Strong class="title">DISCHARGE FEE: </Strong> </h5>

                                </div>
                                <div class="col-sm-8">
                                    <h5  class="content"> KSH. {{ $loan->discharge_fee ?  number_format($loan->discharge_fee, 2) : '0.00' }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row loan-details">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-2"><h5 class="text-dark text-center"><Strong class="title">DESCRIPTION: </Strong> </h5></div>
                                <div class="col-sm-10">
                                    <div class="alert alert-light" role="alert">
                                        {{ $loan->description ? $loan->description : ''}}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr>
                    <div class="row loan-details">
                        <div class="col-sm-4 offset-4">
                            @role('agent')
                                <a href="{{ route('loan.payment', ['id' => $loan->id]) }}" class="btn btn-outline-info btn-block">Add Payment</a>
                            @endrole
                            <a href="{{ route('download.loan.details', ['id' => $loan->id]) }}"  class="btn btn-outline-secondary btn-block">Download Loan Details</a>
                        </div>
                    </div>

                    @role('admin')
                    <div class="row loan-details">
                        <div class="col-sm-12 col-md-12">
                            <div class="card bg-default text-center">
                                <approve-loan loan-details = "{{ $loan }}"></approve-loan>
                            </div>
                        </div>
                    </div>
                    @endrole
                </div>
            </div>

        </div>
    </div>

@endsection