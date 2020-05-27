@extends('master')

@section('title') Publicações @endsection

@section('body')
    <a href="{{route('post.create')}}" class="ui green button"> <i class="icon plus"></i> Novo</a>
    <table class="ui celled striped table">
        <thead>
            <tr>
                <th> Título </th>
                <th> Publicação </th>
                <th> Página </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td>{{$post->title}}</td>
                    <td>{{$post->publication->format('d/m/Y H:i')}}</td>
                    <td>{{$post->page()->first()->name}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection