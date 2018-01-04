@extends(Auth()->user()->hasRole('admin') ? 'admin/layouts/main': 'agent/layout/main')

@section('content')

@endsection