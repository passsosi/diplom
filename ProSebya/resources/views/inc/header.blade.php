@section('header')

<header style="background-color: rgb(193, 180, 218);">
   <a href="/">Про себя</a>
   <a href="/logout" style="{{Auth::check() ? '' : 'display:none' }}">Выйти</a>
   <a href="/login" style="{{Auth::check() ? 'display:none' : '' }}">Войти</a>
   <a href="/profile" style="{{Auth::check() ? '' : 'display:none' }}">Профиль</a>
</header>
