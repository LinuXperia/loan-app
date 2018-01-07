@php
    $name = $user->borrowerPersonalDetails->sname . ' ' . $user->borrowerPersonalDetails->fname;
    $account = $user->borrowerPersonalDetails->account;
    $idNumber = $user->borrowerPersonalDetails->idNumber;
    $mobile = $user->borrowerPersonalDetails->mobile;
    $address = $user->borrowerPersonalDetails->address;
    $pin = $user->borrowerPersonalDetails->pin;
    $dob = $user->borrowerPersonalDetails->dob;
    $marital = $user->borrowerPersonalDetails->marital;
    $education = $user->borrowerPersonalDetails->education;
    $nationality = $user->borrowerPersonalDetails->nationality;
@endphp

@component('mail::message')
# First Line Credit

Dear {{ $name }}, <br>

Your Account has successfully been created with First Line Credit waiting for approval. <br>

@component('mail::table')
    | Name          | Account         | ID Number  | Mobile     | Address    |
    | :------------- |:-------------:| :--------:|:--------:|:--------:|
    | {{ $name }}      | {{ $account }}      | {{ $idNumber }}     |  {{ $mobile }}   |   {{ $address }} |

@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
