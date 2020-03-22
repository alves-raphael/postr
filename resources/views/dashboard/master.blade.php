<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link rel="stylesheet" href="{{asset('semanticui/semantic.min.css')}}">
    <title>Postr - @yield('title')</title>
</head>
<body>
    
    @yield('body')
    <footer>
        {{date("Y")}}
    </footer>
    <script src="{{asset('js/main.js')}}"></script>
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('semanticui/semantic.min.js')}}"></script>
    <script src="{{asset('js/functions.js')}}"></script>
    @yield('js')
</body>
</html>
    