@extends('layouts.app')

@section('title-block')
    Профиль пользователя: @if ($user) {{ $user->name }} {{ $user->surname }} @else Не добавлено @endif
@endsection

@section('content-block')
    <div class="profile">
        @if ($user)
            <h2>Профиль пользователя: {{ $user->name }} {{ $user->surname }}</h2>

            <div class="profile-info">
                <div class="column">
                    <p>Имя: {{ $user->name }}</p>
                    <p>Отчество: {{ $user->patronymic }}</p>
                    <p>Фамилия: {{ $user->surname }}</p>
                </div>

                <div class="column">
                    <p>Email: {{ $user->email }}</p>
                    <p>Город: {{ $user->city ? $user->city : 'Не добавлен' }}</p>
                    <p>Школа: {{ $user->school ? $user->school : 'Не добавлена' }}</p>
                </div>
            </div>

            <form method="GET" action="{{ route('edit-profile') }}">
                @csrf
                <button class="edit" type="submit">Редактировать профиль</button>
            </form>

            <form method="POST" action="{{ route('delete-account') }}">
                @csrf
                <button class="delete" type="submit">Удалить аккаунт</button>
            </form>
        @else
            <main class="autherror">
                <h1>Пользователь не авторизован</h1>
                <p>Пожалуйста, <a href="{{ route('login') }}">войдите в систему</a>, чтобы увидеть свой профиль.</p>
            </main>
        @endif
    </div>
@endsection
