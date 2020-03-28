<nav id="menu">
    <di>
        <span id="logo">Postr</span>
    </div>
    <div class="links">
        @if(!Auth::check())
            <a href="#about">Sobre</a>
            <a href="#plans">Planos</a>
            <a href="#contact">Contato</a>
            <a href="{{route('login')}}">Entrar</a>
        @endif
    </div>
</nav>