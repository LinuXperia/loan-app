@extends('admin.layouts.main')
@section('beforeStyles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
@endsection

@section('content')

@include('admin.layouts.partials._loanStatistics')

<div class="row">
    <div class="col-sm-12 ">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> <strong> UN APPROVED LOANS</strong>
            </div>
            <div class="card-body">
                {!! $html->table() !!}
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    {!! $html->scripts() !!}
@endsection