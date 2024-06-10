@extends('layouts.app')

@section('title-block', 'Учителя')

@section('content-block')
    <style>
        .admin-list {
            max-width: 800px;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #0056b3;
            border-radius: 8px;
            background-color: #f8f9fa;
        }
        .admin-list h2 {
            font-size: 2em;
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
        }
        .admin-list ul {
            list-style: none;
            padding: 0;
        }
        .admin-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        .admin-list li form {
            display: inline-block;
        }
        .admin-list button.delete-admin {
            padding: 5px 10px;
            font-size: 0.9em;
            color: white;
            background-color: #dc3545;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .admin-list button.delete-admin:hover {
            background-color: #c82333;
        }
        .admin-list a.add-admin {
            display: block;
            width: calc(100% - 20px);
            margin: 40px auto 0;
            padding: 10px;
            font-size: 1em;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
        }
        .admin-list a.add-admin:hover {
            background-color: #0056b3;
        }

        .admin-list a.edit-admin {
            padding: 5px 10px;
            font-size: 0.9em;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            position: absolute;
            right: 430px;
        }
        .admin-list a.edit-admin:hover {
            background-color: #0056b3;
        }
    </style>

    <div class="admin-list">
        <h2>Список учителей</h2>
        @if(session('success'))
            <div style="color: green; margin-bottom: 20px; text-align: center;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="color: red; margin-bottom: 20px; text-align: center;">
                {{ session('error') }}
            </div>
        @endif

        <ul>
            @foreach($teachers as $teacher)
                <li>
                    {{ $teacher->surname }} {{ $teacher->name }} {{ $teacher->patronymic }} ({{ $teacher->email }})
                    <a href="{{ route('edit-teacher-page', $teacher->id) }}" class="edit-admin">Редактировать</a>
                    <form action="{{ route('delete-teacher', $teacher->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этого учителя?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-admin">Удалить</button>
                    </form>
                </li>
            @endforeach
        </ul>
        <a href="{{ route('add-teacher-page') }}" class="add-admin">Добавить учителя</a>
    </div>
@endsection
