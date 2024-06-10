@extends('layouts.app')

@section('title-block', 'Авторизация')

@section('content-block')
    <form class="login-form" method="POST" action="{{ route('login') }}">
        @csrf
        <h2>Авторизация</h2>
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
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>

        <div>
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" required>
        </div>

        <div >
            <button type="submit">Войти</button>
        </div>
        <p>Нет аккаунта? <a href="{{ route('registration-page') }}">Зарегистрируйтесь</a></p>
    </form>
@endsection
