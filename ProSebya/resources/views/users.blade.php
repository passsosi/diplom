@extends('layout')
@section('content')

<table style="width: 75%; margin: 0 auto; margin-top: 20px;">
    <tr>
      <th style="border: 1px solid rgb(83, 128, 251); padding: 10px;">id</th>
      <th style="border: 1px solid rgb(83, 128, 251); padding: 10px;">Имя</th>
      <th style="border: 1px solid rgb(83, 128, 251); padding: 10px;">Фамилия</th>
      <th style="border: 1px solid rgb(83, 128, 251); padding: 10px;">Отчество</th>
      <th style="border: 1px solid rgb(83, 128, 251); padding: 10px;">Возраст</th>
      <th style="border: 1px solid rgb(83, 128, 251); padding: 10px;">Результаты 1 теста</th>
      <th style="border: 1px solid rgb(83, 128, 251); padding: 10px;">Результаты 2 теста</th>
    </tr>
    @foreach($users as $user)
    <tr>
      <td style="border: 1px solid rgb(83, 128, 251); padding: 10px;">{{$user->id}}</td>
      <td style="border: 1px solid rgb(83, 128, 251); padding: 10px;">{{$user->name}}</td>
      <td style="border: 1px solid rgb(83, 128, 251); padding: 10px;">{{$user->surname}}</td>
      <td style="border: 1px solid rgb(83, 128, 251); padding: 10px;">{{$user->patronymic}}</td>
      <td style="border: 1px solid rgb(83, 128, 251); padding: 10px;">{{$user->age}}</td>
      <td style="border: 1px solid rgb(83, 128, 251); padding: 10px;">{{$user->test1resultSTRING}}</td>
      <td style="border: 1px solid rgb(83, 128, 251); padding: 10px;">{{$user->test2resultSTRING}}</td>
      <td><a href="/user-profile/{{$user->id}}">Подробнее</a></td>
      
    </tr>
    @endforeach
  </table>

@endsection