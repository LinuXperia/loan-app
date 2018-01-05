@extends('admin.layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12 ">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> <strong>AGENT DETAILS</strong>
                </div>
                <div class="card-body">
                    <agent-details agent-details="{{ $agentDetails }}"></agent-details>

                </div>
            </div>
        </div>
    </div>
@endsection
