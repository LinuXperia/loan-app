@extends('agent.layout.main')

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
                        Name: <span class="text-info text-capitalize">{{ $customer->name . ' ' . $customer->fname}}</span>
                        &nbsp; &nbsp;
                        Phone: <span class="text-info text-capitalize">{{ $customer->mobile }} </span>
                        &nbsp; &nbsp;
                        Email: <span class="text-info text-capitalize">{{ $customer->email }} </span>
                        &nbsp; &nbsp;
                        Address: <span class="text-info text-capitalize">{{ $customer->address }} </span>
                        &nbsp; &nbsp;
                    </div>
                </div>

            </div>

            <loan-details
                customer-details = "{{ $customer }}"
                agent-Details = "{{ Auth()->user() }}"
            >

            </loan-details>
        </div>
    </div>
</div>

@endsection