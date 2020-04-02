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
    @include('includes.navbar')
    <section id="banner">
        <div class="desc">
            Automatize sua campanha de marketing em redes socias
        </div>
    </section>
    <section id="about" class="text-section center">
        <h1>Sobre</h1>    
        <p>
            Ipsum incididunt tempor excepteur ea proident adipisicing id. Ullamco enim veniam irure nulla enim sint id est proident consectetur. Lorem excepteur qui anim exercitation nulla velit. Magna exercitation ex esse deserunt et consectetur.Non cupidatat magna magna aute irure irure culpa qui aliquip amet sint fugiat sunt. Aute sunt eiusmod nostrud exercitation excepteur qui laborum deserunt eiusmod Lorem officia consequat. Ipsum aliquip Lorem quis non sit voluptate labore culpa occaecat minim nulla ipsum ex qui. 
            
            Excepteur officia exercitation id irure ut. Incididunt incididunt eu non eu non irure sunt nostrud dolore. Cupidatat enim ut pariatur cillum tempor enim ex.
            
            Sit ad anim amet ut reprehenderit ut magna aliqua occaecat magna cillum deserunt duis. Est velit et ut deserunt sit ea ad. Commodo ullamco nisi eu anim qui velit sint. Excepteur nulla reprehenderit minim quis velit irure enim laborum magna anim labore amet minim proident. Laboris laborum non nulla Lorem tempor exercitation adipisicing esse dolor. Laboris est quis laborum veniam irure ex laboris ullamco incididunt reprehenderit laborum. Aliqua officia qui ut do elit excepteur ex voluptate Lorem in voluptate.
            
            Proident in do ea cupidatat non exercitation quis. Excepteur in ad reprehenderit sunt laboris Lorem proident non do elit tempor. Exercitation nulla elit ea Lorem ipsum magna consequat. Mollit et amet dolore sit incididunt commodo incididunt et magna consectetur sunt exercitation amet. In do ad aute do do minim quis aliqua incididunt ipsum. Voluptate ea reprehenderit laborum occaecat. Velit enim eu sunt excepteur.
            
            Consectetur occaecat velit qui ea magna ex aute irure nulla sit aute. Labore anim sunt deserunt nostrud est sunt cillum Lorem. Minim voluptate eu ullamco id consequat culpa adipisicing nulla fugiat cillum laboris amet sit occaecat. Consectetur consectetur enim veniam nostrud mollit aliqua quis est et velit enim magna sit est.
            
            Voluptate ullamco minim non dolor est sit culpa veniam. Deserunt sunt nisi anim commodo proident sit qui nulla culpa esse ad anim id. Id consequat sit officia eu. Pariatur qui nulla laboris culpa reprehenderit anim nulla voluptate aliquip voluptate.
        </p>    
    </section>
    <section id="plans" class="text-section">
        <h1 class="center"> Planos </h1>
        <div class="ui card">
            <div class="content">
                <div class="header">Starter</div>
            </div>
            <div class="content">
                <h4 class="ui sub header">Beneficios</h4>
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
        <div class="ui card">
            <div class="content">
                <div class="header">Standard</div>
            </div>
            <div class="content">
                <h4 class="ui sub header">Beneficios</h4>
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
        <div class="ui card">
            <div class="content">
                <div class="header">Premium</div>
            </div>
            <div class="content">
                <h4 class="ui sub header">Beneficios</h4>
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
    </section>

    <footer>
        {{date("Y")}}
    </footer>
    <script src="{{asset('js/main.js')}}"></script>
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('semanticui/semantic.min.js')}}"></script>
    <script src="{{asset('js/functions.js')}}"></script>
</body>
</html>
