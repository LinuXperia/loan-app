@component('mail::message')
    # FIRST LINE CREDIT

    Dear {{ $payment->loan->user->name }},

    Your payment Application has been received waiting for approval.

    Thanks,
    {{ config('app.name') }}
@endcomponent
