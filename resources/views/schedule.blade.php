@extends('master')

@section('title') Cronograma @endsection

@section('body')
<form class="ui form">
    <div class="four fields">
        <div class="field">
          <label>Facebook</label>
          <select class="ui search dropdown" name="facebook">
           <option value="">Selecione...</option>
           @foreach ($week as $key => $day)
               <option value="{{ $key }}">{{ $day }}</option>
           @endforeach
          </select>
        </div>
        <div class="field">
        <label>Twitter</label>
            <select class="ui search dropdown" name="twitter">
                <option value="">Selecione...</option>
                @foreach ($week as $key => $day)
                    <option value="{{ $key }}">{{ $day }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <label>Linkedin</label>
            <select class="ui search dropdown" name="facebook">
                <option value="">Selecione...</option>
                @foreach ($week as $key => $day)
                    <option value="{{ $key }}">{{ $day }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <label>Instagram</label>
            <select class="ui search dropdown" name="facebook">
                <option value="">Selecione...</option>
                @foreach ($week as $key => $day)
                    <option value="{{ $key }}">{{ $day }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <input type="submit" class="ui green button" value="Salvar">
</form>
@endsection