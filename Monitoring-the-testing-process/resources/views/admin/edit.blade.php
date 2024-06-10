@extends('layouts.app')

@section('title-block', 'Редактировать профиль администратора')

@section('content-block')
    <style>
        .edit-profile-form {
            max-width: 600px;
            margin: 60px auto;
            padding: 20px;
            border: 1px solid #0056b3;
            border-radius: 8px;
            background-color: #f8f9fa;
        }
        .edit-profile-form h2 {
            font-size: 2em;
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
        }
        .edit-profile-form div {
            margin-bottom: 15px;
        }
        .edit-profile-form label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #007bff;
        }
        .edit-profile-form input {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            color: #333;
        }
        .edit-profile-form input[type="text"],
        .edit-profile-form input[type="email"] {
            display: block;
        }
        .edit-profile-form button.edit {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .edit-profile-form button.edit:hover {
            background-color: #0056b3;
        }
    </style>

    <div class="edit-profile-form">
        <h2>Редактировать профиль</h2>
        <form action="{{ route('admin.update-profile') }}" method="POST">
            @csrf
            <div>
                <label for="name">Имя:</label>
                <input type="text" id="name" name="name" value="{{ $admin->name }}" required>
            </div>
            <div>
                <label for="patronymic">Отчество:</label>
                <input type="text" id="patronymic" name="patronymic" value="{{ $admin->patronymic }}" required>
            </div>
            <div>
                <label for="surname">Фамилия:</label>
                <input type="text" id="surname" name="surname" value="{{ $admin->surname }}" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{ $admin->email }}" required>
            </div>
            <div>
                <button type="submit" class="edit">Сохранить изменения</button>
            </div>
        </form>
    </div>
@endsection
