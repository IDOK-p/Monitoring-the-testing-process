@extends('layouts.app')

@section('title-block', 'Детали класса')

@section('content-block')
    <div class="details">
        @if ($user)
            <h1>Список учеников класса: {{ $class->name }}</h1>
            @if (session('success'))
                <div class="alert alert-success" style="color: green">
                    {{ session('success') }}
                </div>
            @endif
            <ul class="student-list">
                @foreach ($students->sortBy(['surname', 'name', 'patronymic']) as $student)
                    <li class="student-item">{{ $student->surname }} {{ $student->name }} {{ $student->patronymic }}
                        <form action="{{ route('deleteStudent', $student->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этого ученика?');" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button class="remove-student-btn" type="submit">❌</button>
                        </form>
                    </li>
                @endforeach
            </ul>

            <a href="{{ route('addStudentForm', $class) }}" class="add-student-button">Добавить ученика</a>
            <form action="{{ route('deleteClass', $class->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этот класс?');">
                @csrf
                @method('DELETE')
                <button class="delete-class-button" type="submit">Удалить класс</button>
            </form>
        @else
            <main class="autherror">
                <h1>Пользователь не авторизован</h1>
                <p>Пожалуйста, <a href="{{ route('login') }}">войдите в систему</a>, чтобы редактировать класс.</p>
            </main>
        @endif
    </div>
@endsection
