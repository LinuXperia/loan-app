@extends('admin.layouts.main')
@section('beforeStyles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12 ">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> <strong> INACTIVE AGENTS</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            {!! $dataTable->table(['class' => 'table table-responsive-sm table-striped'], false) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    {!! $dataTable->scripts() !!}
@endsection