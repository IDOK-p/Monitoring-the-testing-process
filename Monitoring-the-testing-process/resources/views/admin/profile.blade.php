@extends('layouts.app')

@section('title-block')
    Профиль пользователя: @if ($admin) {{ $admin->name }} {{ $admin->surname }} @else Не добавлено @endif
@endsection

@section('content-block')
    <style>
        .admin-profile {
            max-width: 800px;
            margin: 110px auto;
            padding: 20px;
            border: 1px solid #0056b3;
            border-radius: 8px;
            background-color: #f8f9fa;
        }
        .admin-profile h2 {
            font-size: 2em;
            color: #0056b3;
            margin-bottom: 20px;
            text-align: center;
        }
        .admin-profile .profile-info {
            display: flex;
            justify-content: space-between;
        }
        .admin-profile .column {
            width: 48%;
        }
        .admin-profile p {
            font-size: 1em;
            margin-bottom: 10px;
            color: #333;
        }
        .admin-profile button {
            font-size: 1em;
            padding: 10px 20px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            width: 100%;
            margin: 10px 0;
        }
        .admin-profile .edit {
            background-color: #007bff;
        }
        .admin-profile .edit:hover {
            background-color: #0056b3;
        }
        .admin-profile .delete {
            background-color: #dc3545;
        }
        .admin-profile .delete:hover {
            background-color: #c82333;
        }
    </style>
    <div class="admin-profile">
        @if ($admin)
            <h2>Профиль администратора: {{ $admin->name }} {{ $admin->surname }}</h2>

            <div class="profile-info">
                <div class="column">
                    <p>Имя: {{ $admin->name }}</p>
                    <p>Отчество: {{ $admin->patronymic }}</p>
                </div>

                <div class="column">
                    <p>Фамилия: {{ $admin->surname }}</p>
                    <p>Email: {{ $admin->email }}</p>
                </div>
            </div>

            <form method="GET" action="{{ route('admin.edit-profile') }}">
                @csrf
                <button class="edit" type="submit">Редактировать профиль</button>
            </form>

            <form method="POST" action="{{ route('admin.delete-account') }}">
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
