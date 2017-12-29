@extends('teller.layout.main')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-4">
                        <strong>Loan Details Form</strong>
                    </div>
                    <div class="col-sm-8">
                        Name: <span class="text-info text-capitalize">{{ $borrower->name . ' ' . $borrower->fname}}</span>
                        &nbsp; &nbsp;
                        Phone: <span class="text-info text-capitalize">{{ $borrower->mobile }} </span>
                        &nbsp; &nbsp;
                        Email: <span class="text-info text-capitalize">{{ $borrower->email }} </span>
                        &nbsp; &nbsp;
                        Address: <span class="text-info text-capitalize">{{ $borrower->address }} </span>
                        &nbsp; &nbsp;
                    </div>
                </div>

            </div>

            <loan-details
                borrower-details = "{{ $borrower }}"
                agent-Details = "{{ Auth()->user() }}"
            >

            </loan-details>
        </div>
    </div>
</div>

@endsection