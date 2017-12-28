@extends('teller.layout.main')

@section('content')

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
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="personalDetails" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <strong>Borrower Personal Details</strong>
                        </div>

                        <personal-details
                                personal-details = "{{ $personalDetails }}"
                        >

                        </personal-details>
                    </div>
                </div>
                <div class="tab-pane" id="kin" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <strong>Borrower Next of Details</strong>
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
                            <strong>Borrower Bank Details</strong>
                        </div>

                        <bank-details
                                bank-details = "{{ $bankDetails }}"
                        >

                        </bank-details>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>

        $("#myTab").on("click", function(){
            var _tab=$(this).closest(".tab-pane").attr("id");
            $("a[href='#"+_tab+"']").parent().hide();
            $("#"+_tab).hide();
        });

    </script>
@endsection