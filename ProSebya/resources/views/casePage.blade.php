@extends('layout')
@section('content')
    <form action="{{ route('caseResult', ['cid' => $cData[0]->id]) }}" method="post" style="width: 920px; margin: 0 auto; background-color:rgb(221, 220, 218); padding: 10px">
        @csrf
        @foreach ($qData as $el)
            @foreach ($mData as $file)
                @if ($file->question_id == $el->id)
                    @if ($file->format == 'pdf' || $file->format == 'docx' || $file->format == 'pptx' || $file->format == 'doc')
                        <div style="margin-top:20px">
                            <a style="font-size:24px; width: 100%; padding: 5px"
                                href="{{ route('file-output', ['id' => $file->id]) }}">{{ $file->name }}</a>
                        </div>
                    @else
                        @if ($file->format == 'jpeg' || $file->format == 'png' || $file->format == 'jpg')
                            <img src="data:image/jpeg;base64,{{ base64_encode($file->file) }}"
                                class="img-fluid w-100 card-img-top"
                                style="padding: 20px; max-width: 100%;0 max-height: 520px; object-fit: cover;"
                                alt="Image">
                        @else
                            <div style="width: 100%; margin: 0 auto; padding: 10px" name="importDivs"
                                id="file-content-{{ $file->id }}">
                                <!-- Содержимое файла будет загружено сюда -->
                            </div>

                            <script>
                                $(document).ready(function() {
                                    @if ($file != null)
                                        loadFileContent({{ $file->id }});
                                    @endif
                                });

                                function loadFileContent(id) {
                                    $.ajax({
                                        url: "{{ route('file-output', ['id' => $file->id]) }}",
                                        type: "GET",
                                        success: function(response) {
                                            $('#file-content-' + id).html(response);
                                        }
                                    });
                                }
                            </script>
                        @endif
                    @endif
                @endif
            @endforeach
            <h4 style="width: 100%; padding: 5px">{{ $el->text }}</h4>
            <select name="answers[]"
                style="width: 100%; margin: 0 auto; background-color:rgb(236, 235, 233); padding: 10px">
                @foreach ($aData as $item)
                    @if ($item->caseQuestion_id == $el->id)
                        <option type="text" id="answer" name="answer" value="{{ $item->id }}">{{ $item->text }}
                        </option>
                    @endif
                @endforeach
            </select>
            <br />
        @endforeach
        <br />
        <input type="submit" value="Отправить"
            style="font-size: 14pt; width: 200px; margin: 0 auto; background-color:rgb(255, 255, 255); padding: 5px">
    </form>
@endsection
