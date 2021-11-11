@extends('master')

@section('title') Assuntos @endsection

@section('body')
    <button class="ui green button" id="new">
        <i class="icon plus"></i> Novo
    </button>

    <h2> Em progresso </h2>
    @if(empty($progress))
        <div class="ui warning message">
            <div class="header">
                Aviso!
            </div>
            Não há nenhum assunto em progresso.
        </div>
    @else
        <div class="ui cards">
            <div class="card">
                <div class="content">
                    <div class="header">
                        <p>{{ $progress->title }}</p>
                    </div>
                    {{-- <div class="description">
                        <i class="facebook square icon bigger"></i>
                        <i class="twitter square icon bigger"></i>
                        <i class="linkedin square icon bigger"></i>
                    </div> --}}
                </div>
                {{-- <div class="extra content">
                    <div class="ui two buttons">
                        <div class="ui basic red button">Cancelar</div>
                    </div>
                </div> --}}
            </div>
        </div>
    @endif

    <h2> Pendentes </h2>
    @if(empty($pending))
        <div class="ui warning message">
            <div class="header">
                Aviso!
            </div>
            Não há nenhum assunto em pendente.
        </div>
    @else
        <table class="ui celled striped table">
            <thead>
                <tr>
                    <th> ID </th>
                    <th> Ordem </th>
                    <th> Título </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pending as $topic)
                    <tr>
                        <td>{{ $topic->id }}</td>
                        <td>{{ $topic->order }}</td>
                        <td>{{ $topic->title }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <h2> Finalizados </h2>
    @if(empty($done))
        <div class="ui warning message">
            <div class="header">
                Aviso!
            </div>
            Não há nenhum assunto em finalizado.
        </div>
    @else
            <table class="ui celled striped table">
                <thead>
                    <tr>
                        <th> ID </th>
                        <th> Ordem </th>
                        <th> Título </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($done as $topic)
                        <tr>
                            <td>{{ $topic->id }}</td>
                            <td>{{ $topic->order }}</td>
                            <td>{{ $topic->title }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    @endif


    <div class="ui tiny modal">
        <div class="header">
          Novo assunto
        </div>
        <div class="content">
            <form class="ui form" id="create-new" method="POST" action="{{route('topic.create')}}">
                @csrf
                <div class="field">
                    <label>Título</label>
                    <input type="text" name="title" >
                </div>
                
            </form>
        </div>
        <div class="actions">
            <div class="ui black deny button">
                Cancelar
            </div>
            <button class="ui green button" id="submit" type="submit">
              Cadastrar
            </button>
        </div>
      </div>
@endsection

@section('js')
    <script src="{{asset('js/topic.js')}}"></script>
@endsection