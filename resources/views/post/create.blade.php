@extends('master')

@section('title') Publicar @endsection

@section('body')
<form class="ui form"  method="post" action="{{route('post.create.new')}}">
  @csrf
    <div class="three fields">
        <div class="field">
          <label>Título</label>
          <input type="text" name="title" placeholder="Título para controle interno">
        </div>
        <div class="field">
          <label>Rede social</label>
          <select class="ui fluid dropdown" name="social_media_id" id="social-media">
              <option value="">Selecione</option>
              @foreach($socialMedias as $socialMedia)
                <option value="{{$socialMedia->id}}">{{$socialMedia->name}}</option>
              @endforeach
          </select>
        </div>
        <div class="field">
          <label>Página</label>
          <select class="ui fluid dropdown" name="page_id" id="pages">
              <option value="">Selecione</option>
              @foreach($pages as $page)
                <option value="{{$page->id}}">{{$page->name}}</option>
              @endforeach
          </select>
        </div>
    </div>
    <div class="three fields">
      <div class="field">
        <label>Tipo de envio</label>
        <select class="ui fluid dropdown" name="sendnow" id="send-now">
            <option value="">Selecione</option>
            <option value="imediato">Envio imediato</option>
            <option value="agendado">Agendado</option>
            <option value="assunto">Assunto</option>
        </select>
      </div>
      <div class="hidden field disabled" id="release-date">
        <label>Data da publicação</label>
        <input type="date" name="date" id="date" disabled>
      </div>
      <div class="hidden field disabled" id="release-hour">
        <label>Hora da publicação</label>
        <input type="time" name="time" id="time" disabled>
      </div>
      <div class="hidden field" id="assunto">
        <label>Assunto</label>
        <select name="topic_id">
          <option value="">Selecione...</option>
          @foreach ($topics as $topic)
            <option value="{{$topic->id}}">{{$topic->title}}</option>
          @endforeach
        </select>
      </div>
      <input type="hidden" name="publication" id="publish" value="9999-99-99 99:99">
    </div>
    <div class="field">
      <textarea name="body" id="" cols="30" rows="10"></textarea>
    </div>
    <a class="ui button" href="{{route('post.list')}}"> <i class="icon arrow left"></i> Voltar</a>
    <button class="ui green button" type="submit">Salvar</button>
  </form>
@endsection

@section('js')
  <script src="{{asset('js/post/create.js')}}"></script>
@endsection