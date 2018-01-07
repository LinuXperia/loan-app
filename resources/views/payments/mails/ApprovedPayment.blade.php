@component('mail::message')
    # FIRST LINE CREDIT

    Dear {{ $payment->loan->user->name }},

    Your Loan  {{ $payment->loan->reference_no }}   payment   Reference No: {{ $payment->reference_no }}  has been {{ $payment->approved == true ? 'Approved' : 'Declined'}} .

@if($payment->approved == true)

@component('mail::table')
    | AMOUNT PAID         | BALANCE         | RECEIVED ON  |
    | :-------------: |:-------------:| :--------:|
    | ksh.{{ number_format($payment->amount, 2) }} | ksh.{{ number_format($payment->loanBalance($payment->loan_id, $payment->loan->amount_to_pay), 2) }} | {{ $payment->updated_at->toFormattedDateString() }} |

@endcomponent

@endif

    Thanks,
    {{ config('app.name') }}
@endcomponent
