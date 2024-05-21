@extends('layout')
@section('content')
<div style="display: inline-block;">
    <div>
        <img src="data:image/jpeg;base64,{{ base64_encode($user->image) }}" class="img-fluid w-100 card-img-top" style="max-width: 100%; min-height: 420px; max-height: 420px; object-fit: cover;" alt="Image">
    
    <h3>Фамилия: {{$user->surname}}</h3>
    <h3>Имя: {{$user->name}}</h3>
    @if($user->patronymic != null)
    <h3>Отчество: {{$user->patronymic}}</h3>
    @endif
    <h3>Возраст: {{$user->age}}</h3>

    @if($user->test1resultSTRING != null)
        <h3 style="color: green">Первый тест пройден!</h3>
    @else
        <h3 style="color: red">Первый тест не пройден...</h3>
    @endif
    @if($user->test2resultSTRING != null)
        <h3 style="color: green">Второй тест пройден!</h3>
    @else
        <h3 style="color: red">Второй тест не пройден...</h3>
    @endif
    <button class="test-button" type="button" onclick="redirect()">Редактировать</button>
    <script>
        function redirect() {
            window.location.href = "{{ route('editProfileView') }}";
        }
    </script>
    </div>
</div>

@endsection