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
            <h4 class="text-center">Customer Account Details</h4>
            <h5 class="text-center">Account Number:  <strong>{{ $user->borrowerPersonalDetails->account }}</strong></h5>
        </div>
    </div>
    <h2 class="background"><span>Personal Details</span></h2>
    <table class="table ">
        <tbody>
        <tr>
            <th>NAME</th>
            <td>{{ $user->borrowerPersonalDetails->sname . ' ' . $user->borrowerPersonalDetails->fname . ' ' . $user->borrowerPersonalDetails->lname}}</td>
            <th>EMAIL:</th>
            <td>{{ $user->email}}</td>
            <th>REGISTERED ON</th>
            <td>{{ $user->created_at->toFormattedDateString()}}</td>
            <th>REGISTERED BY</th>
            <td>{{ $user::getNameFromId($user->registered_by)}}</td>
        </tr>
        <tr>
            <th>TITLE</th>
            <td>{{ $user->borrowerPersonalDetails->title}}</td>
            <th>NATIONALITY:</th>
            <td>{{ $user->borrowerPersonalDetails->nationality}}</td>
            <th>ID NUMBER/PASSPORT</th>
            <td>{{ $user->borrowerPersonalDetails->idNumber}}</td>
            <th>PIN</th>
            <td>{{ $user->borrowerPersonalDetails->pin}}</td>
        </tr>
        <tr>
            <th>MOBILE</th>
            <td>{{ $user->borrowerPersonalDetails->mobile}}</td>
            <th>TELEPHONE</th>
            <td>{{ $user->borrowerPersonalDetails->telephone ? $user->borrowerPersonalDetails->telephone : 'NA'}}</td>
            <th>DOB</th>
            <td>{{ $user->borrowerPersonalDetails->dob}}</td>
            <th>ADDRESS</th>
            <td>{{ $user->borrowerPersonalDetails->address}}</td>
        </tr>
        <tr>
            <th>OFFICE PHONE</th>
            <td>{{ $user->borrowerPersonalDetails->office ? $user->borrowerPersonalDetails->office : 'NA'}}</td>
            <th>HOME PHONE</th>
            <td>{{ $user->borrowerPersonalDetails->home ? $user->borrowerPersonalDetails->home : 'NA'}}</td>
            <th>MARITAL STATUS</th>
            <td>{{ $user->borrowerPersonalDetails->marital}}</td>
            <th>EDUCATION LEVEL</th>
            <td>{{ $user->borrowerPersonalDetails->education}}</td>
        </tr>
        </tbody>
    </table>

    <h2 class="background"><span>Next of Kin Details</span></h2>

    <table class="table">
        <tr>
            <th>NAME</th>
            <td>{{ $user->borrowerNextOfKin->name }}</td>
            <th>RELATIONSHIP</th>
            <td>{{ $user->borrowerNextOfKin->relationship }}</td>
            <th>PHONE</th>
            <td>{{ $user->borrowerNextOfKin->phone}}</td>
            <th>EMAIL</th>
            <td>{{ $user->borrowerNextOfKin->email}}</td>
            <th>ADDRESS</th>
            <td>{{ $user->borrowerNextOfKin->address}}</td>
        </tr>
    </table>

    <h2 class="background"><span>Bank Details</span></h2>

    <table class="table">

        @foreach($user->borrowerBankDetails as $bankDetail)
            <tr>
                <th>BANK NAME</th>
                <td>{{ $bankDetail->name }}</td>
                <th>BRANCH</th>
                <td>{{ $bankDetail->branch }}</td>
                <th>TYPE</th>
                <td>{{ $bankDetail->type }}</td>
                <th>FACILITY</th>
                <td>{{ $bankDetail->facility }}</td>
                <th>AMOUNT</th>
                <td>ksh. {{ number_format($bankDetail->amount, 2) }}</td>
            </tr>
        @endforeach
    </table>

    <h2 class="background"><span>Residence Details</span></h2>

    <table class="table">
        <tr>
            <th>ADDRESS</th>
            <td>{{ $user->borrowerResidenceDetails->address }}</td>
            <th>STAY (YRS)</th>
            <td>{{ $user->borrowerResidenceDetails->stay }} Years</td>
            <th>PREVIOUS RESIDENCE</th>
            <td>{{ $user->borrowerResidenceDetails->previous }}</td>
            <th>HOUSE TYPE</th>
            <td>{{ $user->borrowerResidenceDetails->house }}</td>
            <th>PERMANENT ADDRESS</th>
            <td>{{ $user->borrowerResidenceDetails->permanent_address }}</td>
        </tr>
    </table>

    <h2 class="background"><span>Work/Business Details</span></h2>

    <table class="table">
        <tr>
            <th>Employment ype</th>
            <td>{{ $user->borrowerWorkDetails->employment_type }}</td>
            <th>EMPLOYER/BUSINESS NAME</th>
            <td>{{ $user->borrowerWorkDetails->employer  ? $user->borrowerWorkDetails->employer : $user->borrowerWorkDetails->business_name }}</td>
            <th>PREVIOUS RESIDENCE</th>
            <td>{{ $user->borrowerWorkDetails->previous }}</td>
            <th>PHONE</th>
            <td>{{ $user->borrowerWorkDetails->phone }}</td>
            <th>ADDRESS</th>
            <td>{{ $user->borrowerResidenceDetails->address }}</td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <h2 class="background"><span>Referees Details</span></h2>

    <table class="table">

        @foreach($user->refereesDetails as $refereesDetail)
            <tr>
                <th>NAME</th>
                <td>{{ $refereesDetail->name }}</td>
                <th>RELATIONSHIP</th>
                <td>{{ $refereesDetail->relationship }}</td>
                <th>ACQUAINTED</th>
                <td>{{ $refereesDetail->acquainted }} years</td>
                <th>NATIONALITY</th>
                <td>{{ $refereesDetail->nationality }}</td>
                <th>PHONE</th>
                <td>{{ $refereesDetail->mobile_phone }}</td>

            </tr>
            <tr>
                <th>HOME CONTACT</th>
                <td>{{ $refereesDetail->home_phone }}</td>
                <th>EMAIL</th>
                <td>{{ $refereesDetail->email }}</td>
                <th>ADDRESS</th>
                <td>{{ $refereesDetail->address }}</td>
                <th>WORK CONTACT</th>
                <td>{{ $refereesDetail->work_phone }}</td>
            </tr>
        @endforeach
    </table>

</body>
</html>