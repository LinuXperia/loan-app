@component('mail::message')
# FIRST LINE CREDIT

Dear {{ $loan->user->name }},

Your Loan <strong>Reference No: {{ $loan->reference_no }}</strong> has been <strong>{{ $loan->approved == true ? 'Approved' : 'Declined'}}</strong> .

@if($loan->approved == true)

@component('mail::table')
    | BORROWED         | TO PAY         | TO PAY ON  |
    | :-------------: |:-------------:| :--------:|
    | ksh.{{ number_format($loan->amount_borrowed, 2) }} | ksh.{{ number_format($loan->amount_to_pay, 2) }} | {{ $loan->payment_date->toFormattedDateString() }} |

@endcomponent

@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
