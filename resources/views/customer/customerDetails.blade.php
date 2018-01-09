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
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#files" role="tab" aria-controls="loan"><i class="icon-paper-clip"></i> Account Files</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="personalDetails" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <strong>Customer Personal Details</strong>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 text-center">

                                @if(file_exists(storage_path().'/app/public/uploads/avatars/' . $personalDetails->user_id . '.png'))

                                    <img src="{{ asset('storage/uploads/avatars/' . $personalDetails->user_id . '.png') }}" class="img-thumbnail mt-2" style="width: 40%" alt="">
                                @else
                                    <img src="/img/default-avatar.png" alt="" class="img-thumbnail mt-2" style="width: 40%">
                                @endif
                            </div>

                            <div class="col-sm-4">
                                <avatar-upload customer-id="{{$personalDetails->user_id }}"></avatar-upload>
                            </div>
                        </div>
                        <hr>

                        <personal-details
                            personal-details = "{{ $personalDetails }}"
                        >
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

                <div class="tab-pane" id="files" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <strong>Account Files</strong>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="text-center">ID CARD IMAGE</h6>
                                    @if(file_exists(storage_path().'/app/public/uploads/account/' . $personalDetails->account . '/idcard.png'))
                                        <a
                                            href="{{asset('storage/uploads/account/' . $personalDetails->account . '/idcard.png') }}"
                                            download="{{ $personalDetails->account }}_id_card">
                                            <img src="{{asset('storage/uploads/account/' . $personalDetails->account . '/idcard.png') }}" class="img-thumbnail" alt="">
                                        </a>
                                    @else
                                        <p class="text-center"> No ID Card Image</p>
                                    @endif
                                </div>
                                <div class="col-sm-3">
                                    <h6 class="text-center">PIN CERTIFICATE</h6>
                                    @if(file_exists(storage_path().'/app/public/uploads/account/' . $personalDetails->account . '/pin.png'))
                                        <a
                                                href="{{asset('storage/uploads/account/' . $personalDetails->account . '/pin.png') }}"
                                                download="{{ $personalDetails->account }}_id_card">
                                            <img src="{{asset('storage/uploads/account/' . $personalDetails->account . '/pin.png') }}" class="img-thumbnail" alt="">
                                        </a>
                                    @else
                                        <p class="text-center"> No Pin Certificate</p>
                                    @endif
                                </div>
                                <div class="col-sm-3"></div>
                                <div class="col-sm-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-6 offset-3">
            <div class="card bg-default text-center">
                <a href="{{ route('download.account.details',['id' => $personalDetails->user_id]) }}" class="btn btn-primary">Download Account Details</a>
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