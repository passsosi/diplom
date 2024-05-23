@extends('layout')
@section('content')

<h2 style="margin-top: 30px; text-align: center;">Кейс "{{$caseName}}"</h2>
<table style="width: 75%; margin: 0 auto; margin-top: 20px;">
    <tr>
      <th style="border: 1px solid rgb(83, 128, 251); padding: 10px;">id</th>
      <th style="border: 1px solid rgb(83, 128, 251); padding: 10px;">ФИО</th>
      <th style="border: 1px solid rgb(83, 128, 251); padding: 10px;">Вопрос</th>
      <th style="border: 1px solid rgb(83, 128, 251); padding: 10px;">Ответ</th>
      <th style="border: 1px solid rgb(83, 128, 251); padding: 10px;">Риск</th>
    </tr>
    @foreach($caseResult as $el)
    <tr>
      <td style="border: 1px solid rgb(83, 128, 251); padding: 10px;">{{$el->id}}</td>
      <td style="border: 1px solid rgb(83, 128, 251); padding: 10px;">{{$FIO}}</td>
      @foreach($questions as $question)
      @if($question->id == $el->question_id)
      <td style="border: 1px solid rgb(83, 128, 251); padding: 10px;">{{$question->text}}</td>
      @endif
      @endforeach
      @foreach($answers as $answer)
      @if($answer->id == $el->answer_id)
      <td style="border: 1px solid rgb(83, 128, 251); padding: 10px;">{{$answer->text}}</td>
      @if($answer->risk == 3)
      <td style="background-color:rgb(255, 192, 167); border: 1px solid rgb(83, 128, 251); padding: 10px;">{{$answer->risk}}</td>
      @endif
      @if($answer->risk == 2)
      <td style="background-color:rgb(199, 242, 90); border: 1px solid rgb(83, 128, 251); padding: 10px;">{{$answer->risk}}</td>
      @endif
      @if($answer->risk == 1)
      <td style="background-color:rgb(147, 255, 147); border: 1px solid rgb(83, 128, 251); padding: 10px;">{{$answer->risk}}</td>
      @endif
      @endif
      @endforeach    
    </tr>
    @endforeach
  </table>

@endsection