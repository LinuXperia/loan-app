@extends(Auth()->user()->hasRole('admin') ? 'admin/layouts/main': 'agent/layout/main')

@section('beforeStyles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
@endsection
@section('content')
    @include('customer.partial._loan_details')
    <div class="row">
        <div class="col-sm-12">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#personalDetails" role="tab" aria-controls="home"><i class="icon-user"></i> Personal Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#kin" role="tab" aria-controls="kin"><i class="icon-user-following"></i> Next Of Kin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#bank" role="tab" aria-controls="bank"><i class="icon-wallet"></i> Bank Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#loan" role="tab" aria-controls="loan"><i class="icon-credit-card"></i> Loan Details</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="personalDetails" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <strong>Customer Personal Details</strong>
                        </div>

                        <personal-details
                                personal-details = "{{ $personalDetails }}"                        >

                        </personal-details>
                    </div>
                </div>
                <div class="tab-pane" id="kin" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <strong>customer Next of Details</strong>
                        </div>

                        <next-of-kin-details
                                kin-details = "{{ $nextOfKinDetails }}"
                        >

                        </next-of-kin-details>
                    </div>
                </div>
                <div class="tab-pane" id="bank" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <strong>customer Bank Details</strong>
                        </div>

                        <bank-details
                                bank-details = "{{ $bankDetails }}"
                        >
                        </bank-details>
                    </div>
                </div>
                <div class="tab-pane" id="loan" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <strong>Loan Details</strong>
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
        </div>
    </div>

    @role('admin')
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="card bg-default text-center">
                    <approve-customer customer-details = "{{ $customer }}"></approve-customer>
                </div>
            </div>
        </div>
    @endrole

@endsection

@section('scripts')
    <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    {!! $dataTable->scripts() !!}
@endsection