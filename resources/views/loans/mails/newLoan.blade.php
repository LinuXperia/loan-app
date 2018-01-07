@component('mail::message')
# FIRST LINE CREDIT

Dear {{ $loan->user->name }}, <br>

Your Loan Application has been received waiting for approval.


Thanks,<br>
{{ config('app.name') }}
@endcomponent
