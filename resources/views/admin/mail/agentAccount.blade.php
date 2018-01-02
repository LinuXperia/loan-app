@component('mail::message')
# First line Credit Agent Account Details

Your First line Credit Account has been created. After login change your password.
<h5>Name: {{ $user->name }}</h5>
<h5>Email Address: {{ $user->email }}</h5>
<h5>PASSWORD: {{ $password }}</h5>

@component('mail::button', ['url' => url('/login'), 'color' => 'green'])
Click Here To Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
