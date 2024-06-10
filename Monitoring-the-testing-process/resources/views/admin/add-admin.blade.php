@extends('layouts.app')

@section('title-block', 'Добавить администратора')

@section('content-block')
    <style>
        .admin-form {
            max-width: 800px;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #0056b3;
            border-radius: 8px;
            background-color: #f8f9fa;
        }
        .admin-form h2 {
            font-size: 2em;
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
        }
        .admin-form form {
            display: flex;
            flex-direction: column;
        }
        .admin-form label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        .admin-form input {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .admin-form button {
            padding: 10px;
            font-size: 1em;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .admin-form button:hover {
            background-color: #0056b3;
        }
    </style>
    <div class="admin-form">
        <h2>Добавить администратора</h2>
        @if ($errors->any())
            <div style="color: red; margin-bottom: 20px; text-align: center;">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif
        <form action="{{ route('store-admin') }}" method="POST">
            @csrf
            <label for="name">Имя</label>
            <input type="text" name="name" id="name" required>

            <label for="patronymic">Отчество</label>
            <input type="text" name="patronymic" id="patronymic" required>

            <label for="surname">Фамилия</label>
            <input type="text" name="surname" id="surname" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" required>

            <label for="password_confirmation">Подтверждение пароля</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>

            <button type="submit">Добавить администратора</button>
        </form>
    </div>
@endsection