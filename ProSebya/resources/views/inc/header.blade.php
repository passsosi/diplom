@section('header')

    <header class="header">
        <div class="container">
            <a class="header-logo" href="/">Про себя</a>
            <a class="header-logo" href="/profile" style="{{ Auth::check() ? '' : 'display:none' }}">Профиль</a>
            <?php $user = auth()->user(); ?>
            @if ($user != null)
            <?php $user = auth()->user(); ?>
            @if ($user->user_role > 1)
            <a class="header-logo" href="/users" style="{{ Auth::check() ? '' : 'display:none' }}">Пользователи</a>
            @endif
            @endif
            <a class="header-logo" href="/logout" style="{{ Auth::check() ? '' : 'display:none' }}">Выйти</a>
            <a class="header-logo" href="/login" style="{{ Auth::check() ? 'display:none' : '' }}">Войти</a>
        </div>
    </header>
