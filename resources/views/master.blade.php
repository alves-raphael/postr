<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('semanticui/semantic.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link rel="stylesheet" href="{{asset('css/navbar.css')}}">
    <title>Postr - @yield('title')</title>
</head>
<body>
    <div class="ui bottom attached segment pushable">
        <div class="ui visible inverted left vertical sidebar menu">
          <a href="{{route('post.list')}}" class="item active">
            <i class="sticky note icon"></i>
            Publicações
          </a>
          <a class="item">
            <i class="newspaper icon"></i>
            Assuntos
          </a>
          <a class="item">
            <i class="calendar icon"></i>
            Conograma
          </a>
          <a href="{{route('logout')}}" class="item">
            <i class="sign out alternate icon"></i>
            Sair
          </a>
        </div>
        <div class="pusher">
          <div class="ui basic segment" style="padding-right:20%">
            <h1 class="ui header" id="main-title">@yield('title')</h1>
            @include('includes.alerts')
            @yield('body')
          </div>
        </div>
    </div>
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('semanticui/semantic.min.js')}}"></script>
    <script src="{{asset('js/functions.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    @yield('js')
</body>
</html>
    