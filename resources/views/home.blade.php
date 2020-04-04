<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('semanticui/semantic.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/home.css')}}">
    <link rel="stylesheet" href="{{asset('css/navbar.css')}}">
    <title>Postr - home</title>
</head>
<body>
    <div class="ui sidebar inverted vertical menu">
        @include('includes.navbar')
    </div>
    <div class="pusher">
    
    <nav id="menu">
        <div>
            <span id="logo">Postr</span>
        </div>
        <div class="links">
            @include('includes.navbar')
        <button id="sidebar-btn"><i class="icon bars"></i></button>
        </div>
    </nav>
    <section id="banner">
        <div class="desc">
            Automatize sua campanha de marketing em redes socias
        </div>
    </section>
    <section id="about" class="content-section center">
        <h1>Sobre</h1>    
        <p>
            Postr tem como objetivo automatizar o trabalho do profissional de marketing por criar um cronograma de publicação 
            de conteúdo.
            Os softwares existentes atualmente para agendar publicação exige que o usuário programe cada publicação individualmente,
            indicando a rede social, data e horário. Usuários que postam quase o mesmo conteúdo em dias diferentes para cada
            rede social acaba perdendo produtividade devido a um fluxo de trabalho monótono dadas por esses softwares. 
        </p>
        <p>
            A proposta do Postr é criar um cronograma de publicações baseado em fila. A idéia é que o usuário agende uma
            dia da semana e horário para cada rede social, sendo assim, será necessário apenas cadastrar o conteúdo que
            deseja publicar, indicando a rede social e o sistema se encarrega de alocar a publicação para o próximo 
            dia da semana agendado para a rede social escolhida.
        </p>    
    </section>
    <section id="plans" class="content-section">
        <h1 class="center"> Planos </h1>
        <div class="ui cards"> 
            <div class="ui centered card">
                <div class="content">
                    <div class="header">Starter</div>
                </div>
                <div class="content">
                    <h4 class="ui sub header">Benefícios</h4>
                    <ul>
                        <li>Lorem</li>
                        <li>Ipsum</li>
                        <li>Dolor</li>
                    </ul>
                </div>
                <div class="extra content">
                    <button class="ui green button">Adquirir</button>
                </div>
            </div>
            <div class="ui centered card">
                <div class="content">
                    <div class="header">Standard</div>
                </div>
                <div class="content">
                    <h4 class="ui sub header">Benefícios</h4>
                    <ul>
                        <li>Lorem</li>
                        <li>Ipsum</li>
                        <li>Dolor</li>
                    </ul>
                </div>
                <div class="extra content">
                    <button class="ui green button">Adquirir</button>
                </div>
            </div>
            <div class="ui centered card">
                <div class="content">
                    <div class="header">Premium</div>
                </div>
                <div class="content">
                    <h4 class="ui sub header">Benefícios</h4>
                    <ul>
                        <li>Lorem</li>
                        <li>Ipsum</li>
                        <li>Dolor</li>
                    </ul>
                </div>
                <div class="extra content">
                    <button class="ui green button">Adquirir</button>
                </div>
            </div>
        </div>
    </section>

    <footer>
        {{date("Y")}}
    </footer>
</div>
    <script src="{{asset('js/main.js')}}"></script>
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('semanticui/semantic.min.js')}}"></script>
    <script src="{{asset('js/functions.js')}}"></script>
    <script>
        $('#sidebar-btn').click(function(){
            $('.ui.sidebar').sidebar('toggle');
        });
    </script>
</body>
</html>
