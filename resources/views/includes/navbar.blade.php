<a class="item" href="#about">Sobre</a>
<a class="item" href="#plans">Planos</a>
<a class="item" href="#contact">Contato</a>
@if(!Auth::check())
    <a class="item" href="{{route('login')}}">Entrar</a>
@endif
        