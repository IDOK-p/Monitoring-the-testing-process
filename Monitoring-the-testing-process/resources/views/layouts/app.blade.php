<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title-block')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
<header>
    <div class="logo">Web-система для мониторинга тестирования школьников</div>
    <nav>
        @if(session('id'))
            @if(session('user_type') == 'teacher')
                <a href="{{ route('tests-page') }}">Тесты</a>
                <a href="{{ route('class-page') }}">Классы</a>
                <a href="{{ route('journal-page') }}">Журналы</a>
                <a href="{{ route('profile-page') }}">{{ session('name') }} {{ session('surname') }}</a>
                <a href="">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">Выйти</button>
                    </form>
                </a>
            @elseif(session('user_type') == 'admin')
                <a href="{{ route('teachers-page') }}">Учителя</a>
                <a href="{{ route('students-page') }}">Ученики</a>
                <a href="{{ route('admins-page') }}">Администраторы</a>
                <a href="{{ route('cities-page') }}">Города</a>
                <a href="{{ route('schools-page') }}">Школы</a>
                <a href="{{ route('admin-profile-page') }}">{{ session('name') }} {{ session('surname') }}</a>
                <a href="">
                    <form id="logout-form" action="{{ route('admin-logout') }}" method="POST">
                        @csrf
                        <button type="submit">Выйти</button>
                    </form>
                </a>
            @endif
        @else
            <a href="{{ route('home-page') }}">Главная</a>
            <a href="{{ route('download-page') }}">Скачать</a>
            <a href="{{ route('about-page') }}">О нас</a>
            <a href="{{ route('login-page') }}">Войти</a>
            <a href="{{ route('registration-page') }}">Регистрация</a>
        @endif
    </nav>
</header>

<!-- Основной контент страницы -->
@yield('content-block')

<footer>
    &copy; 2024 Web-система для мониторинга тестирования школьников. Все права защищены.
</footer>
</body>
</html>


