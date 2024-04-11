@extends('layout')
@section('content')


<h1 style="text-align: center;">КАКАЯ ТА ШАПКА ХЗ</h1>

<form method="post" style="width: 800px; margin: 0 auto; background-color:rgb(221, 220, 218); padding: 10px">
    @csrf
    @foreach ($qData as $el)
    <?php 
    foreach($mData as $item)
    if ($item->question_id == $el->id) {
        $file = $item;
    }
    ?>
    @if($file != null)
        <img src="data:image/jpeg;base64,{{ base64_encode($file->file) }}" class="img-fluid w-100 card-img-top" style="max-width: 100%; min-height: 420px; max-height: 420px; object-fit: cover;" alt="Image">
    @endif
    <h4>{{$el->text}}</h4>
    <select name="answers[]" style="width: 100%; margin: 0 auto; background-color:rgb(236, 235, 233); padding: 10px"> 
        @foreach ($aData as $item)
        @if($item->caseQuestion_id == $el->id)
        <option type="text" id="answer" name="answer" value="{{$item->id}}">{{$item->text}}</option>
        @endif
        @endforeach
    </select>
    <br/>
    @endforeach
    <br/>
    <input type="submit" value="Отправить" style="font-size: 14pt; width: 200px; margin: 0 auto; background-color:rgb(255, 255, 255); padding: 5px">
</form>


@endsection