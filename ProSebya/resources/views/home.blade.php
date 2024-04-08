@extends('layout')
@section('content')


@if(Auth::check())
    <h1>Вы вошли</h1>
@else
    <h1>Вы не вошли</h1>
@endif



<h1 style="text-align: center;">КАКАЯ ТА ШАПКА ХЗ</h1>
<h2 style="text-align: center;">ТЕСТЫ</h2>
@foreach ($testData as $el)
<div style="display: inline-block;">
    <div>
        <img src="data:image/jpeg;base64,{{ base64_encode($el->image) }}" class="img-fluid w-100 card-img-top" style="max-width: 100%; min-height: 420px; max-height: 420px; object-fit: cover;" alt="Image">
        <div>
            <h2>{{$el->name}}</h2>
            <button type="button" onclick="redirect({{$el->id}})">Пройти тест</button>
        </div>
    </div>
</div>

<script>
    function redirect(categoryId) {
        window.location.href = "{{ route('testpage', ':categoryId') }}".replace(':categoryId', categoryId);
    }
  </script>

@endforeach

<h2 style="text-align: center;">Медиафайлсы</h2>
<h3 style="text-align: center;">Видики</h3>
@foreach ($videoData as $el)
<div style="display: inline-block;">
    <div>
        <img src="data:image/jpeg;base64,{{ base64_encode($el->preview) }}" class="img-fluid w-100 card-img-top" style="max-width: 100%; min-height: 420px; max-height: 420px; object-fit: cover;" alt="Image">
        <div>
            <h2>{{$el->name}}</h2>
        </div>
    </div>
</div>
@endforeach
<h3 style="text-align: center;">Аудио</h3>
@foreach ($litData as $el)
<div style="display: inline-block;">
    <div>
        <img src="data:image/jpeg;base64,{{ base64_encode($el->image) }}" class="img-fluid w-100 card-img-top" style="max-width: 100%; min-height: 420px; max-height: 420px; object-fit: cover;" alt="Image">
        <div>
            <h2>{{$el->name}}</h2>
        </div>
    </div>
</div>
@endforeach
<h3 style="text-align: center;">Литература</h3>
@foreach ($litData as $el)
<div style="display: inline-block;">
    <div>
        <img src="data:image/jpeg;base64,{{ base64_encode($el->image) }}" class="img-fluid w-100 card-img-top" style="max-width: 100%; min-height: 420px; max-height: 420px; object-fit: cover;" alt="Image">
        <div>
            <h2>{{$el->name}}</h2>
        </div>
    </div>
</div>
@endforeach

@endsection

