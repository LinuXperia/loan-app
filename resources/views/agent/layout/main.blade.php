<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">

    @yield('beforeStyles')

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @yield('styles')

</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">

<div id="app">
    @include('agent.layout.partials.header')

    <div class="app-body">

    @include('agent.layout.partials.sidebar')

    <!-- Main content -->
        <main class="main">

            @include('agent.layout.partials.breadcrumps')

            <div class="container-fluid">
                <div class="animated fadeIn">
                    @include('agent.layout.partials._flash')
                    @yield('content')

                </div>

            </div>
            <!-- /.conainer-fluid -->
        </main>

        {{-- @include('agent.layout.partials.aside')--}}

    </div>

</div>
    {{--@include('agent.layout.partials.footer')--}}

<!-- CoreUI main scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>

    @yield('scripts')

</body>
</html>