@extends('layouts.app')

@section('title-block', 'Редактировать администратора')

@section('content-block')
    <style>
        .container {
            max-width: 600px;
            margin: 80px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f8f9fa;
        }

        .container h2 {
            font-size: 1.5em;
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
        }

        .container form {
            display: flex;
            flex-direction: column;
        }

        .container label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .container input[type="text"],
        .container input[type="email"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }

        .container button[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
        }

        .container button[type="submit"]:hover {
            background-color: #0056b3;
        }

    </style>
    <div class="container">
        <h2>Редактировать администратора</h2>
        @if ($errors->any())
            <div style="color: red; margin-bottom: 20px; text-align: center;">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif
        <form action="{{ route('update-admin', $admin->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label for="name">Имя</label>
            <input type="text" name="name" id="name" value="{{ $admin->name }}" required>

            <label for="patronymic">Отчество</label>
            <input type="text" name="patronymic" id="patronymic" value="{{ $admin->patronymic }}" required>

            <label for="surname">Фамилия</label>
            <input type="text" name="surname" id="surname" value="{{ $admin->surname }}" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ $admin->email }}" required>

            <button type="submit">Сохранить изменения</button>
        </form>
    </div>
@endsection
