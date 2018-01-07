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
        <h4 class="text-center">Loan Details</h4>
        <h5 class="text-center">ACCOUNT:  <strong>{{ $loan->user->borrowerPersonalDetails->account }}</strong></h5>
    </div>
</div>
<h2 class="background"><span>Loan Details</span></h2>
<table class="table ">
    <tbody>
    <tr>
        <th>REFERENCE NUMBER</th>
        <td>{{ $loan->reference_no }}</td>
        <th>ISSUED ON</th>
        <td>{{ $loan->created_at->toDayDateTimeString() }}</td>
        <th>AMOUNT BORROWED</th>
        <td>ksh. {{ number_format($loan->amount_borrowed, 2) }}</td>
        <th>AMOUNT TO PAY</th>
        <td>ksh. {{ number_format($loan->amount_to_pay, 2) }}</td>
    </tr>
    <tr>
        <th>DURATION</th>
        <td>{{ $loan->duration }} months</td>
        <th>INTEREST RATE</th>
        <td>{{ $loan->interest_rate }}%</td>
        <th>ISSUED BY</th>
        <td>{{  $loan->user::getNameFromId($loan->agent) }}</td>
        <th>LOAN TYPE</th>
        <td>{{ $loan->loan_type }}</td>
    </tr>
    <tr>
        <th>LEGAL FEE</th>
        <td>ksh. {{ number_format($loan->legal_fee, 2) }}</td>
        <th>PROCESSING FEE</th>
        <td>ksh. {{ number_format($loan->processing_fee, 2) }}</td>
        <th>KRA FEE</th>
        <td>ksh. {{ number_format($loan->kra, 2) }}</td>
        <th>CAR TRACK INSTALLATION</th>
        <td>ksh. {{ number_format($loan->car_track_installation, 2) }}</td>
    </tr>
    <tr>
        <th>CAR TRACK MAINTENANCE</th>
        <td>ksh. {{ number_format($loan->car_track_maintenance, 2) }}</td>
        <th>LOGISTICS FEE</th>
        <td>ksh. {{ number_format($loan->logistics, 2) }}</td>
        <th>MV FEE</th>
        <td>ksh. {{ number_format($loan->mv, 2) }}</td>
        <th>DISCHARGE FEE</th>
        <td>ksh. {{ number_format($loan->discharge_fee, 2) }}</td>
    </tr>
    <tr>
        <th>DESCRIPTION</th>
        <td colspan="7" style="text-align: left">{{ $loan->description  }}</td>
    </tr>
    </tbody>
</table>
</body>
</html>