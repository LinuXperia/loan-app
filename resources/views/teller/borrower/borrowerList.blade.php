@extends('teller.layout.main')

@section('beforeStyles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">

@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset("css/entypo/css/entypo.css") }}">
@endsection

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Simple Table
                </div>
                <div class="card-body">
                    {!! $html->table(['class' => 'table table-responsive-sm table-striped'], false) !!}
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    {!! $html->scripts() !!}
@endsection