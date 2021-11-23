@extends('master')

@section('title') Cronograma @endsection

@section('body')
<form class="ui form" method="POST" action="{{route('schedule.save')}}">
    @csrf
    <div class="fields">
        @foreach ($socialMedias as $socialMedia)
            <div class="grouped fields" style="margin:10px">
                <input type="hidden" name="data[{{$socialMedia->id}}][social_media_id]" value="{{$socialMedia->id}}">
                <h2>{{$socialMedia->name}}</h2>
                <div class="field">
                    <label for="{{$socialMedia->name}}_weekday">Dia da semana</label>
                    <select class="ui search dropdown" name="data[{{$socialMedia->id}}][weekday]" id="{{$socialMedia->name}}_weekday">
                        <option value="">Selecione...</option>
                        @foreach ($week as $key => $day)
                            <option {{($socialMedia->schedule['weekday'] ?? '') == $key ? 'selected' : ''}} value="{{ $key }}">{{ $day }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label for="{{$socialMedia->name}}_time">Horário</label>
                    <input type="time" name="data[{{$socialMedia->id}}][time]" id="{{$socialMedia->name}}_time" value="{{$socialMedia->schedule['time'] ?? ''}}">
                </div>
            </div>
        @endforeach
    </div>
    <input type="submit" class="ui green button" value="Salvar">
</form>
@endsection