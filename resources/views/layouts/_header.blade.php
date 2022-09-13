<header>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdown2">
        @guest
            <li><a class="dropdown-item" href="{{ route('login') }}">Войти</a></li>
            <li><a class="dropdown-item" href="{{ route('register') }}">Регистрация</a></li>
        @endguest
        @auth
{{--            <li><a class="dropdown-item" href="{{ route('order.show') }}">Заказы</a></li>--}}
            <li><hr class="dropdown-divider"></li>
            @can('admin-panel')
                <li><a class="dropdown-item" href="{{ route('admin.home') }}">Админ-панель</a></li>
            @endcan
            <li><a class="dropdown-item" href="{{ route('logout') }}">Выйти</a></li>
        @endauth
    </ul>
</header>
