@extends('layout')
@section('content')


<h1 style="text-align: center;">КАКАЯ ТА ШАПКА ХЗ</h1>

<form action="{{ route('testResult', ['tid' => $tData[0]->id, 'tmid' => $tMData[0]->id]) }}" method="post" style="width: 800px; margin: 0 auto; background-color:rgb(221, 220, 218); padding: 10px">
    @csrf
    @foreach ($qData as $el)
    <h4>{{$el->text}}</h4>
    <select name="answers[]" style="width: 100%; margin: 0 auto; background-color:rgb(236, 235, 233); padding: 10px"> 
        @foreach ($aData as $el)
        <option type="text" id="answer" name="answer" value="{{$el->id}}">{{$el->text}}</option>
        @endforeach
    </select>
    <br/>
    @endforeach
    <br/>
    <input type="submit" value="Отправить" style="font-size: 14pt; width: 200px; margin: 0 auto; background-color:rgb(255, 255, 255); padding: 5px">
</form>


@endsection