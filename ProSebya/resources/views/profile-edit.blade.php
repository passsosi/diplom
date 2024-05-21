@extends('layout')
@section('content')
    <div style="display: inline-block;">
        <div>
            <form action="{{ route('editProfile') }}" method="post" enctype="multipart/form-data">
                @csrf
                <img src="data:image/jpeg;base64,{{ base64_encode($user->image) }}" class="img-fluid w-100 card-img-top"
                    style="max-width: 100%; min-height: 420px; max-height: 420px; object-fit: cover;" alt="Image">
                <input type="file" id="image" name="image">
                <h3>Фамилия:
                    <input type="text" id="surname" name="surname" value="{{ $user->surname }}" />
                    @error('surname')
                        <div class="alert">{{ $message }}</div>
                    @enderror
                </h3>
                <h3>Имя:
                    <input type="text" id="name" name="name" value="{{ $user->name }}" />
                    @error('name')
                        <div class="alert">{{ $message }}</div>
                    @enderror
                </h3>
                <h3>Отчество:
                    <input type="text" id="patronymic" name="patronymic" value="{{ $user->patronymic }}" />
                    @error('surname')
                        <div class="alert">{{ $message }}</div>
                    @enderror
                </h3>
                <h3>Возраст:
                    <input type="text" id="age" name="age" value="{{ $user->age }}" />
                    @error('age')
                        <div class="alert">{{ $message }}</div>
                    @enderror
                </h3>
                <button class="test-button" type="submit">Сохранить</button>
            </form>
        </div>
        <div>
            <form action="{{ route('editProfileAuth') }}" method="post" enctype="multipart/form-data">
                @csrf
                <h3>Email:
                    <input type="email" id="email" name="email" value="{{ $user->email }}" />
                    @error('email')
                        <div class="alert">{{ $message }}</div>
                    @enderror
                </h3>
                <h3>Старый пароль:
                    <input type="password" id="password" name="password" />
                    @error('password')
                        <div class="alert">{{ $message }}</div>
                    @enderror
                </h3>
                <h3>Пароль:
                    <input type="password" id="newpassword" name="newpassword" />
                    @error('newpassword')
                        <div class="alert">{{ $message }}</div>
                    @enderror
                </h3>
                <button class="test-button" type="submit">Сохранить</button>
            </form>
        </div>
    </div>
@endsection
