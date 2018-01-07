@component('mail::message')
# First Line Credit

Dear {{ $user->name }}, <br>

Your Account has successfully been Approved. <br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
