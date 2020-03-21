<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{assets('css/style.css')}}">
    <link rel="stylesheet" href="{{assets('semanticui/semantic.min.css')}}">
    <title>@yield('title')</title>
</head>
<body>
    <nav id="menu">
        <ul>
            <li>Sobre</li>
            <li>Planos</li>
            <li>Contato</li>
            @if(Auth::check())
                <li>Entrar</li>
            @else
                <li>Sair</li>
            @endif
        </ul>
    </nav>

    @yield('body')

    <footer>
        {{date("Y")}}
    </footer>
    <script src="{{assets('js/main.js')}}"></script>
    <script src="{{assets('js/jquery.min.js')}}"></script>
    <script src="{{assets('semanticui/semantic.min.js')}}"></script>
    <script src="{{assets('js/functions.js')}}"></script>
    @yield('js')
</body>
</html>
    