@extends('layout')
@section('content')
<main class="main">
    <div class="container">
        <h1 class="page_test-title">{{ $tData[0]->name }}</h1>
        <div class="question-cards">
            <form action="{{ route('testResult', ['tid' => $tData[0]->id, 'tmid' => $tMData[0]->id]) }}" method="post">
                @csrf
                @foreach ($qData as $el)
                    <div class="question-card">
                        <p class="question">{{ $el->text }}</p>
                        <select name="answers[]"
                            style="width: 100%; margin: 0 auto; background-color:rgb(236, 235, 233); padding: 10px">
                            @foreach ($aData as $el)
                                <option type="text" id="answer" name="answer" value="{{ $el->id }}">
                                    {{ $el->text }}</option>
                            @endforeach
                        </select>
                        <br />
                    </div>
                @endforeach
                <br />
                <input type="submit" value="Отправить" class="question-button">
        
            </form>
        </div>
    </div>
</main>
@endsection
