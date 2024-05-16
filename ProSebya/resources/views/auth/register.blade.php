@extends('layout')
@section('content')
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-light" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <form class="form-auth" style="width: 60%;" action="{{ route('register') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <h2 class="fw-bold mb-2 text-uppercase">Регистрация</h2>
                                    <p class="text-white-50 mb-5">Введите данные</p>

                                    <div class="form-outline form-white mb-4">
                                        <label class="form-label" for="name">Имя</label>
                                        @error('name')
                                            <div class="alert">{{ $message }}</div>
                                        @enderror
                                        <input type="text" id="name" name="name"
                                            class="form-control form-control-lg" />

                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <label class="form-label" for="name">Фамилия</label>
                                        <input type="text" id="surname" name="surname"
                                            class="form-control form-control-lg" />
                                        @error('surname')
                                            <div class="alert">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <label class="form-label" for="name">Отчество (при наличии)</label>
                                        <input type="text" id="patronymic" name="patronymic"
                                            class="form-control form-control-lg" />
                                        @error('pat')
                                            <div class="alert">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <label class="form-label" for="name">Возраст</label>
                                        @error('age')
                                            <div class="alert">{{ $message }}</div>
                                        @enderror
                                        <input type="text" id="age" name="age"
                                            class="form-control form-control-lg" />

                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <label class="form-label" for="email">Email</label>
                                        @error('email')
                                            <div class="alert">{{ $message }}</div>
                                        @enderror
                                        <input type="email" id="email" name="email"
                                            class="form-control form-control-lg" />

                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <label class="form-label" for="password">Пароль</label>
                                        @error('password')
                                            <div class="alert">{{ $message }}</div>
                                        @enderror
                                        <input type="password" id="password" name="password"
                                            class="form-control form-control-lg" />

                                    </div>

                                    {{-- <div class="form-outline form-white mb-4">
                      <input type="file" id="image"  name="image" class="form-control">
                      <label class="form-label" for="email">Аватрка</label>
                      @error('image')
                      <div class="alert">{{ $message }}</div>
                        @enderror
                      </div>
                    </div> --}}

                                    <button class="btn bg-primary btn-outline-light btn-lg px-5"
                                        type="submit">Зарегистрироваться</button>

                                    <a href="/login">У меня уже есть аккаунт</a>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
