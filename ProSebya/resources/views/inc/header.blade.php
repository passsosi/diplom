@section('header')

<header class="header">
   <div class="container">
   <a class="header-logo" href="/">Про себя</a>
   <a class="header-logo" href="/profile" style="{{Auth::check() ? '' : 'display:none' }}">Профиль</a>
   <a class="header-logo" href="/logout" style="{{Auth::check() ? '' : 'display:none' }}">Выйти</a>
   <a class="header-logo" href="/login" style="{{Auth::check() ? 'display:none' : '' }}">Войти</a>
   </div>
</header>
