@extends('dashboard.master')

@section('title') Publicar @endsection

@section('body')
 <form class="ui form">
    <div class="three fields">
        <div class="field">
          <label>Título</label>
          <input type="text" name="first-name" placeholder="First Name">
        </div>
        <div class="field">
          <label>Data da publicação</label>
          <input type="date" name="last-name" placeholder="Last Name">
        </div>
    </div>
    <div class="field">
        <div class="ui toggle checkbox">
            <input type="checkbox" name="gift" tabindex="0" class="hidden">
            <label>Enviar imediatamente?</label>
        </div>
    </div>
    <div class="field">
        <textarea name="" id="" cols="30" rows="10"></textarea>
    </div>
    <button class="ui green button" type="submit">Publicar</button>
  </form>
@endsection