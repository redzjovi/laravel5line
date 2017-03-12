<html>
<head>
    <title> @yield('title') </title>
    <link href="{{ URL::asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ URL::asset('js/jquery/jquery.min.js') }}"></script>
</head>
<body>
    @include('back._partials.top')
    @include('back._partials.messages')
    @yield('content')
    <script src="{{ URL::asset('js/tether/tether.min.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('js/custom.js') }}"></script>
</body>
</html>