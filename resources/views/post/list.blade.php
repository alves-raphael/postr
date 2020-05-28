@extends('master')

@section('title') Publicações @endsection

@section('body')
    <a href="{{route('post.create.view')}}" class="ui green button"> <i class="icon plus"></i> Novo</a>
    <table class="ui celled striped table">
        <thead>
            <tr>
                <th> ID </th>
                <th> Título </th>
                <th> Publicação </th>
                <th> Página </th>
                <th> Ações </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td>{{$post->id}}</td>
                    <td>{{$post->title}}</td>
                    <td>{{$post->publication->format('d/m/Y H:i')}}</td>
                    <td>{{$post->page()->first()->name}}</td>
                    <td>
                        <a class="icon" href="{{route('post.edit.view', $post->id)}}" data-content="Editar/Detalhes">
                            <i class="edit icon action"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection