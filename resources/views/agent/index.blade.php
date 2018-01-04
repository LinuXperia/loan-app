@extends('agent.layout.main')

@section('content')
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
                        <span class="float-right">10</span>
                    </div>
                    <div>
                    <span>
                      <small>Today's Total Amount</small>
                    </span>
                        <span class="float-right">
                      <small>Ksh. 5000</small>
                    </span>
                    </div>
                    <div class="chart-wrapper" style="height:38px;">
                        <canvas class="chart-7 chart chart-line" height="38"></canvas>
                    </div>
                    <div class="chart-wrapper" style="height:38px;">
                        <canvas class="chart-8 chart chart-bar" height="38"></canvas>
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
                                echo strtoupper(date('F Y'));
                            @endphp TOTAL customerS
                        </span>
                        <span class="float-right">1,000</span>
                    </div>
                    <div>
                    <span>
                      <small>Total Amount</small>
                    </span>
                        <span class="float-right">
                      <small>Ksh: 50, 000</small>
                    </span>
                    </div>
                    <div class="chart-wrapper" style="height:38px;">
                        <canvas class="chart-7-2 chart chart-line" height="38"></canvas>
                    </div>
                    <div class="chart-wrapper" style="height:38px;">
                        <canvas class="chart-8-2 chart chart-bar" height="38"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!--/.col-->
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-header bg-success">
                    <div class="font-weight-bold">
                        <span>UNPROCESSED LOANS</span>
                        <span class="float-right">50</span>
                    </div>
                    <div>
                    <span>
                      <small>Today 6:43 AM</small>
                    </span>
                        <span class="float-right">
                      <small>+432,50 (15,78%)</small>
                    </span>
                    </div>
                    <div class="chart-wrapper" style="height:38px;">
                        <canvas class="chart-7-3 chart chart-line" height="38"></canvas>
                    </div>
                    <div class="chart-wrapper" style="height:38px;">
                        <canvas class="chart-8-3 chart chart-bar" height="38"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!--/.col-->
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-header bg-warning">
                    <div class="font-weight-bold">
                        <span>PROCESSED LOANS</span>
                        <span class="float-right">70</span>
                    </div>
                    <div>
                    <span>
                      <small>Today 6:43 AM</small>
                    </span>
                        <span class="float-right">
                      <small>+432,50 (15,78%)</small>
                    </span>
                    </div>
                    <div class="chart-wrapper" style="height:38px;">
                        <canvas class="chart-7-4 chart chart-line" height="38"></canvas>
                    </div>
                    <div class="chart-wrapper" style="height:38px;">
                        <canvas class="chart-8-4 chart chart-bar" height="38"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!--/.col-->

    </div>
    <!--/.row-->

@endsection