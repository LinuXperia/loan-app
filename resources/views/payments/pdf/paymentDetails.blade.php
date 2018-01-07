<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    {{-- <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">--}}
    <title>Account Details</title>

    <style>
        body {
            /*  font-family: 'Roboto', sans-serif;*/
        }

        table{
            width: 100%;
        }
        h2{
            font-size: 36px;
        }

        h2.background {
            font-size: 15px;
            margin-top: 30px;
            text-align: center;
            z-index: 1;
            font-weight: 600;
        }

        table th{
            font-size: 10px;
            padding-top :2px ;
            padding-bottom:2px ;
            font-weight: 600;
        }
        table td{
            font-size: 9px;
            color: #4c4c4c;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="row">
    <div class="col-sm-6 offset-3">
        <h2 class="text-center"><strong>FIRST LINE CREDIT</strong></h2>
        <h4 class="text-center">Loan Payment Details</h4>
        <h5 class="text-center">ACCOUNT:  <strong> {{ $payment->loan->user->borrowerPersonalDetails->account }}</strong></h5>
        <h5 class="text-center">LOAN REF:  <strong>{{ $payment->loan->reference_no }}</strong></h5>
    </div>
</div>
<h2 class="background"><span>Loan Payment Details</span></h2>
<table class="table ">
    <tbody>
    <tr>
        <th>REFERENCE NUMBER</th>
        <td>{{ $payment->reference_no }}</td>
        <th>PAID ON</th>
        <td>{{ $payment->created_at->toDayDateTimeString() }}</td>
        <th>TOTAL LOAN</th>
        <td>ksh. {{ number_format($payment->loan->amount_to_pay, 2) }}</td>
        <th>PAID AMOUNT</th>
        <td>ksh. {{ number_format($payment->amount, 2) }}</td>
    </tr>
    <tr>
        <th>PAYMENT MODE</th>
        <td>{{ $payment->payment_mode }}</td>
        <th>CODE</th>
        @if($payment->payment_mode == 'cash')
            <td>cash</td>
        @else
            <td>{{ $payment->payment_mode == 'cheque'  ? $payment->cheque_no : $payment->mpesa_no}}</td>
        @endif
        <th colspan="2">RECEIVED BY</th>
        <td colspan="2">{{ $payment->loan->user::getNameFromId($payment->agent) }}</td>
    </tr>
    <tr>
        <th>REMARKS</th>
        <td colspan="7" style="text-align: left;">{{$payment->description}}</td>
    </tr>
    </tbody>
</table>
</body>
</html>