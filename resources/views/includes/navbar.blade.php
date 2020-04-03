<nav id="menu">
    <di>
        <span id="logo">Postr</span>
    </div>
    <div class="links">
        <a href="#about">Sobre</a>
        <a href="#plans">Planos</a>
        <a href="#contact">Contato</a>
        @if(!Auth::check())
            <a href="{{route('login')}}">Entrar</a>
        @endif
        <button><i class="icon bars"></i></button>
    </div>
</nav>