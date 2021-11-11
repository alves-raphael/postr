@extends('master')

@section('title') Assuntos @endsection

@section('body')
    <button class="ui green button" id="new">
        <i class="icon plus"></i> Novo
    </button>

    @if(empty($topics))
    <div class="ui warning message">
        <div class="header">
            Aviso!
        </div>
        Nenhum registro foi encontrado.
    </div>
    @else
    <div class="scroll-table">
        <table class="ui celled striped table">
            <thead>
                <tr>
                    <th> ID </th>
                    <th> Ordem </th>
                    <th> Título </th>
                    <th> Status </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topics as $topic)
                    <tr>
                        <td>{{ $topic->id }}</td>
                        <td>{{ $topic->order }}</td>
                        <td>{{ $topic->title }}</td>
                        <td>{{ $topic->getStatusDescription() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
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