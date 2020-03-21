@if(isset($errors) and count($errors) > 0)
<div class="ui negative message" id="alert">
  <div class="header">Atenção</div>
  <ul>
    @foreach($errors->all() as $error)
      <li>{{$error}}</li>
    @endforeach
  </ul>
</div>
@endif
@if(Session::has("success"))
<div class="ui positive message">
  <div class="header">Concluído!</div>
    {{Session::get("success")}}
  </div>
@endif
@if(Session::has("warning"))
<div class="ui warning message">
  <div class="header">Atenção!</div>
    {{Session::get("warning")}}
  </div>
@endif

@if(Session::has("fail"))
<div class="ui negative message">
  <div class="header">Ops! :(</div>
    {{Session::get("fail")}}
  </div>
@endif