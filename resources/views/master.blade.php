<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('semanticui/semantic.min.css')}}">
    <title>@yield('title')</title>
</head>
<body>
    <nav id="menu">
        <di>
            <span id="logo">Postr</span>
        </div>
        <div class="links">
            <a href="#about">Sobre</a>
            <a href="#plans">Planos</a>
            <a href="#contact">Contato</a>
            @if(Auth::check())
                <a href="{{route('logout')}}">Sair</a>
            @else
                <a href="{{route('login')}}">Entrar</a>
            @endif
        </div>
    </nav>

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
    