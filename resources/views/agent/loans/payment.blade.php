@extends('agent.layout.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Loan Payment
                </div>
                <div class="card-body">
                    <loan-payment loan = "{{ $loan }}"></loan-payment>
                </div>
            </div>

        </div>
    </div>
@endsection