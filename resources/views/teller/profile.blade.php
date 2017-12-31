@extends('teller.layout.main')

@section('content')
    <div class="row">
        <div class="col-sm-12 ">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> <strong> CUSTOMER SERVICE PROFILE</strong>
                </div>
                <div class="card-body">
                   <div class="row">
                       <div class="col-sm-4">
                           <h6><strong>NAME :</strong> {{  strtoupper(Auth()->user()->name) }}</h6>
                       </div>
                       <div class="col-sm-4">
                           <h6><strong>EMAIL :</strong> {{  Auth()->user()->email }}</h6>
                       </div>
                       <div class="col-sm-4">
                           <h6><strong>CREATED AT :</strong> {{  strtoupper(Auth()->user()->created_at) }}</h6>
                       </div>
                   </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> <strong>CHANGE PASSWORD</strong>
                </div>
                <div class="card-body">

                    <change-password
                        user-id = "{{ Auth()->user()->id }}"
                    >

                    </change-password>

                </div>
            </div>
        </div>
    </div>
@endsection