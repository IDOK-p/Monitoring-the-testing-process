@extends('layouts.app')

@section('title-block', 'Регистрация')

@section('content-block')
    <form class="register-form" method="POST" action="{{ route('registration') }}">
        @csrf
        <h2>Регистрация</h2>
        @if ($errors->any())
            <div class="errors">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="form-row">
            <div>
                <label for="surname">Фамилия</label>
                <input type="text" name="surname" id="surname" required>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>

        </div>

        <div class="form-row">
            <div>
                <label for="name">Имя</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div>
                <label for="password">Пароль</label>
                <input type="password" name="password" id="password" required>
            </div>
        </div>

        <div class="form-row">
            <div>
                <label for="patronymic">Отчество</label>
                <input type="text" name="patronymic" id="patronymic" required>
            </div>
            <div>
                <label for="password_confirmation">Подтверждение пароля</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required>
            </div>
        </div>

        <div>
            <button type="submit">Зарегистрироваться</button>
        </div>

        <p>Уже есть аккаунт? <a href="{{ route('login-page') }}">Войдите</a></p>
    </form>
@endsection
