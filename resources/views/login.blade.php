<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('semanticui/semantic.min.css')}}">
    <title>Postr - Entrar</title>
    <style>
        h1 {
            text-align: center;
            color: deepskyblue;
            margin: 1rem !important;
        }

        #login-btns {
            width: 30%;
            margin: auto;
            background-color: rgb(238, 238, 238);
            border-radius: 5px;
            box-shadow: 1px 1px 5px; black;
            padding: 1rem;
        }

        @media screen and (max-width: 900px){
            #login-btns {
                width:80%;
            }
        }
       #login-btns a.ui.button {
           display: block;
           font-size: 1.2rem;
           margin: .5rem;
       }

       #login-btns h3 {
           text-align: center;
       }
    </style>
</head>
<body>
    <h1>Postr</h1>
    <div id="login-btns">
        <h3> Entrar com </h3>
        <a href="{{route('facebook.login')}}" class="ui facebook button"><i class="facebook icon"></i> Facebook </a>
        <a href="#" class="ui instagram button"><i class="instagram icon"></i> Instagram </a>
        <a href="#" class="ui linkedin button"><i class="linkedin icon"></i> LinkedIn </a>
        <a href="#" class="ui twitter button"><i class="twitter icon"></i> Twitter </a>
        <div class="ui divider"></div>
        <a href="{{route('home')}}" class="ui button"><i class="arrow left icon"></i> Voltar </a>
    </div>
</body>
</html>
