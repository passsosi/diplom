@extends('layout')
@section('content')


@if(Auth::check())
    <h1>Вы вошли</h1>
@else
    <h1>Вы не вошли</h1>
@endif

@error('err')
    <h3>{{$message}}<h3>
@enderror

<h1 style="text-align: center;">КАКАЯ ТА ШАПКА ХЗ</h1>
<h2 style="text-align: center;">ТЕСТЫ</h2>
@foreach ($testData as $el)
<div style="display: inline-block;">
    <div>
        <img src="data:image/jpeg;base64,{{ base64_encode($el->image) }}" class="img-fluid w-100 card-img-top" style="max-width: 100%; min-height: 420px; max-height: 420px; object-fit: cover;" alt="Image">
        <div>
            <h2>{{$el->name}}</h2>
            <button type="button" onclick="redirectT({{$el->id}})">Пройти тест</button>
        </div>
    </div>
</div>

<script>
    function redirectT(categoryId) {
        window.location.href = "{{ route('testpage', ':categoryId') }}".replace(':categoryId', categoryId);
    }
</script>
@endforeach



<?php $user = auth()->user(); ?>
@if($user != null)
<h2 style="text-align: center;">КЕЙСЫ</h2>
@if($user->test1resultSTRING != null || $user->test2resultSTRING != null || $user->test3resultSTRING != null) 
@foreach ($caseData as $el)
<div style="display: inline-block;">
    <div>
        <img src="data:image/jpeg;base64,{{ base64_encode($el->preview) }}" class="img-fluid w-100 card-img-top" style="max-width: 100%; min-height: 420px; max-height: 420px; object-fit: cover;" alt="Image">
        <div>
            <h2>{{$el->name}}</h2>
            <button type="button" onclick="redirectC({{$el->id}})">Пройти тест</button>
        </div>
    </div>
</div>

<script>
    function redirectC(categoryId) {
        window.location.href = "{{ route('casepage', ':categoryId') }}".replace(':categoryId', categoryId);
    }
</script>
@endforeach

@else
<h3>Пройдите тест, чтобы увидеть рекомендуемые вам кейсы!</h3>
@endif
@else
<h3>Войдите в аккаунт чтобы увидеть больше контента!</h3>
@endif

@endsection

