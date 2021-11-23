@extends('master')

@section('title') Publicações @endsection

@section('body')
    <a href="{{route('post.create.view')}}" class="ui green button"> 
        <i class="icon plus"></i> Novo
    </a>
    
    @if(empty($posts))
        <div class="ui warning message">
            <div class="header">
                Aviso!
            </div>
            Nenhum registro foi encontrado.
        </div>
    @else
        <form action="{{route('post.list')}}" class="ui form" style="margin: 10px">
            <div class="four fields">
                <div class="field">
                    <label for="socialMedia">Rede Social</label>
                    <select name="socialMedia" id="socialMedia">
                        <option value="">Selecione...</option>
                        @foreach ($socialMedias as $socialMedia)
                            <option value="{{$socialMedia->id}}">{{$socialMedia->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label for="start">Início</label>
                    <input type="date" name="start" id="start">
                </div>
                <div class="field">
                    <label for="end">Fim</label>
                    <input type="date" name="end" id="end">
                </div>
                <div class="field">
                    <label for="" style="opacity:0">A</label>
                    <input type="submit" class="ui blue button" value="Filtrar">
                </div>
            </div>
        </form>
        <div class="scroll-table">
            <table class="ui celled striped table">
                <thead>
                    <tr>
                        <th> ID </th>
                        <th> Título </th>
                        <th> Publicação </th>
                        <th> Publicada </th>
                        <th> Rede Social </th>
                        <th> Ações </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{$post->id}}</td>
                            <td>{{$post->title}}</td>
                            <td>{{$post->publication->format('d/m/Y H:i')}}</td>
                            <td class="centered"><i class="{{ $post->published ? 'check green' : 'close red' }} icon"></i></td>
                            <td>{{$post->socialMedia->name .' | '.  $post->page->name}}</td>
                            <td class="centered">
                                <a class="icon" href="{{route('post.edit.view', $post->id)}}" data-content="Editar/Detalhes">
                                    <i class="edit icon action"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection