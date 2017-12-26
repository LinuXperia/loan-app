<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body id="login">
<div id="app">

    <div class="login-page">
        <div class="form">
            <form class="form-horizontal login-form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                    <div class="col-sm-12">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <small style="color: #cc100a; font-size: 10px">{{ $errors->first('email') }}</small>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                    <div class="col-sm-12">
                        <input id="password" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <small style="color: #cc100a; font-size: 10px">{{ $errors->first('password') }}</small>
                            </span>
                        @endif
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    Login
                </button>
                <p class="message"><a href="{{ route('password.request') }}">Forgot Password?</a></p>

            </form>
        </div>
    </div>

</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>