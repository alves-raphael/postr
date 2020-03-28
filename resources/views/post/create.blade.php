@extends('master')

@section('title') Publicar @endsection

@section('body')
 <form class="ui form">
    <div class="four fields">
        <div class="field">
          <label>Título</label>
          <input type="text" name="title" placeholder="Título para controle interno">
        </div>
        <div class="field">
          <label>Rede social</label>
          <select class="ui fluid dropdown" name="sendnow" id="send-now">
              <option value="">Selecione</option>
              <option value="true">Facebook</option>
          </select>
        </div>
        <div class="field">
            <label>Enviar imediatamente?</label>
            <select class="ui fluid dropdown" name="sendnow" id="send-now">
                <option value="">Selecione</option>
                <option value="true">Sim</option>
                <option value="false">Não</option>
            </select>
        </div>
        <div class="disabled field" id="release-date">
          <label>Data da publicação</label>
          <input type="date" name="date" disabled>
        </div>
    </div>
    <div class="field">
        <textarea name="body" id="" cols="30" rows="10"></textarea>
    </div>
    <a class="ui button" href="{{route('post.list')}}"> <i class="icon arrow left"></i> Voltar</a>
    <button class="ui green button" type="submit">Publicar</button>
  </form>
@endsection

@section('js')
  <script>
      var releaseDate = $('#release-date');
      $('#send-now').change(function(){
        if (this.value == 'true'){
            disable(releaseDate);
        } else {
            enable(releaseDate);
        }
      });

    $('.ui.form').form({
        fields: {
            title: 'empty',
            sendnow: 'empty',
            body: 'empty',
            date: 'empty',
        }
    });
  </script>
@endsection