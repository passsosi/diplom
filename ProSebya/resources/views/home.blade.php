@extends('layout')
@section('content')

    @error('err')
        <h3 class="error">{{ $message }}</h3>
            @enderror

            <main class="main">
                <div class="container">
                    <h1 class="page_tests-title">Тесты</h1>
                    <div class="test-cards">
                        @foreach ($testData as $el)
                            <div class="test-card">
                                <img src="data:image/jpeg;base64,{{ base64_encode($el->image) }}"
                                    class="img-fluid w-100 card-img-top" alt="Image">
                                <div class="card-content">
                                    <h2 class="card-text">{{ $el->name }}</h2>
                                    <button class="test-button" type="button"
                                        onclick="redirectT({{ $el->id }})">Пройти тест</button>
                                </div>

                            </div>

                            <script>
                                function redirectT(categoryId) {
                                    window.location.href = "{{ route('testpage', ':categoryId') }}".replace(':categoryId', categoryId);
                                }
                            </script>
                        @endforeach
                    </div>


                    <?php $user = auth()->user(); ?>
                    @if ($user != null)

                        <h2 class="page_tests-title">Кейсы</h2>

                        @if ($user->test1resultSTRING != null || $user->test2resultSTRING != null || $user->test3resultSTRING != null)
                        <div class="test-cards">
                            @foreach ($caseData as $el)
                                <div class="test-card">
                                    <img src="data:image/jpeg;base64,{{ base64_encode($el->preview) }}"
                                        class="img-fluid w-100 card-img-top" alt="Image">
                                    <div class="card-content">
                                        <h2 class="card-text">{{ $el->name }}</h2>
                                        <button class="test-button" type="button"
                                            onclick="redirectC({{ $el->id }})">Пройти</button>
                                    </div>
                                </div>

                                <script>
                                    function redirectC(categoryId) {
                                        window.location.href = "{{ route('casepage', ':categoryId') }}".replace(':categoryId', categoryId);
                                    }
                                </script>
                            @endforeach
                            @if($user->user_role > 1)
                            <button class="test-button" type="button"
                            onclick="createC()">Создать кейс
                            </button>

                            <script>
                                function createC(categoryId) {
                                    window.location.href = "{{ route('caseCreateView') }}".replace(':categoryId', categoryId);
                                }
                            </script>
                            @endif
                        </div>
                        @else
                            <h3 class="error">Пройдите тест, чтобы увидеть рекомендуемые вам кейсы!</h3>
                        @endif
                    @else
                        <h3 class="error">Войдите в аккаунт чтобы увидеть больше контента!</h3>
                    @endif
                </div>
            </main>

        @endsection
