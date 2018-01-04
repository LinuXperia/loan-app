@extends('agent.layout.main')

@section('styles')
    <style>
        .results-box{
            border: 1px solid #f4f4f4;
            margin-top: 10px;
        }
        .result{
            font-size: 14px;
            border-bottom: 1px solid #F4F4F4;
            padding-top: 8px;
            padding-bottom:8px;

        }
        .result:hover{
            background:#F4F4F4 ;
        }
        .result a{
            color: #263a42;
            text-decoration: none;
            width: 100%;
        }
        .result a span.title{
            color: #919191;
        }
        ul.ais-pagination{
            padding-left: 63%;
        }
        ul.ais-pagination li{

            display: inline-block;
            font-size: 11px;
            color: #00bafd;
        }
        ul.ais-pagination li a{
            color: #829aa2;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body text-center">
                    <div class="text-muted small text-uppercase font-weight-bold">Search For Customer Account</div>
                    <hr>
                    <div class="h2 py-3">
                        <ais-index app-id="{{ config('scout.algolia.id') }}"
                                   api-key="{{ env('ALGOLIA_SEARCH') }}"
                                   index-name="borrower_personal_details">

                            <ais-input placeholder="Search customer..." class="form-control"></ais-input>
                            <div class="results-box">
                                <ais-results>
                                    <template slot-scope="{ result }">

                                        <div class="result">
                                            <a :href='result.user_id + "/new"'>

                                                <span class="title">Account No : </span> @{{ result.account }}  |
                                                <span class="title">Surname : </span> @{{ result.sname }}  |
                                                <span class="title">First Name : </span> @{{ result.fname }}  |
                                                <span class="title">ID / Passport Number : </span> @{{ result.idNumber }}  |
                                                <span class="title">Mobile Number : </span> @{{ result.mobile }}  |
                                                <span class="title">PIN : </span> @{{ result.pin }}
                                            </a>
                                        </div>

                                    </template>
                                </ais-results>
                                <ais-pagination :padding="5"></ais-pagination>
                                <ais-powered-by></ais-powered-by>
                            </div>


                        </ais-index>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection