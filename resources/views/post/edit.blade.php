@extends('master')

@section('title') Editar publicação @endsection

@section('body')
<form class="ui form"  method="post" action="{{route('post.edit', $post->id)}}">
  @csrf
    <div class="three fields">
        <div class="field">
          <label>Título</label>
          <input type="text" name="title" placeholder="Título para controle interno" value="{{ htmlspecialchars($post->title) }}" {{$disabled}}>
        </div>
        <div class="field {{$disabled}}">
          <label>Rede social</label>
          <select class="ui fluid dropdown" name="social_media_id" id="social-media">
              <option value="">Selecione</option>
              @foreach($socialMedias as $socialMedia)
                <option value="{{$socialMedia->id}}" {{$socialMedia->id == $post->socialMediaId ? 'selected' : '' }} {{$disabled}}>
                  {{$socialMedia->name}}
                </option>
              @endforeach
          </select>
        </div>
        <div class="field {{$disabled}}">
          <label>Página</label>
          <select class="ui fluid dropdown" name="page_id" id="pages">
              <option value="">Selecione</option>
              @foreach($pages as $page)
                <option value="{{$page->id}}" {{ $page->id == $post->pageId ? 'selected' : '' }} {{$disabled}}>
                  {{$page->name}}
                </option>
              @endforeach
          </select>
        </div>
    </div>
    <div class="two fields">
      <div class="{{$disabled}} field" id="release-date">
        <label>Data da publicação</label>
        <input type="date" name="date" id="date" {{$disabled}} value="{{$post->publication->format('Y-m-d')}}">
      </div>
      <div class="{{$disabled}} field" id="release-hour">
        <label>Hora da publicação</label>
        <input type="time" name="time" id="time" {{$disabled}} value="{{$post->publication->format('H:i')}}">
      </div>
      <input type="hidden" name="publication" id="publish" value="{{$post->publication->format('Y-m-d H:i')}}" disabled>
    </div>
    <div class="field">
      <textarea name="body" id="" cols="30" rows="10" {{$disabled}}>
        {{trim($post->body)}}
      </textarea>
    </div>
    <a class="ui button" href="{{route('post.list')}}"> <i class="icon arrow left"></i> Voltar</a>
    <button class="ui green button" type="submit" {{$disabled}}>Salvar</button>
  </form>
@endsection

@section('js')
  <script src="{{asset('js/post/create.js')}}"></script>
@endsection