@extends('master')

@section('title') Assuntos @endsection

@section('body')
<a href="{{route('post.create.view')}}" class="ui green button">
    <i class="icon plus"></i> Novo
</a>

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
                <th> Publicado </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($topics as $topic)
                <tr>
                    <td>{{ $topic->id }}</td>
                    <td>{{ $topic->order }}</td>
                    <td>{{ $topic->title }}</td>
                    <td>{{ $topic->done }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection