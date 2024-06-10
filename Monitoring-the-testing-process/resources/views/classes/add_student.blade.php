@extends('layouts.app')

@section('title-block', 'Добавление ученика по Email')

@section('content-block')
    <main class="add-student-form">
        @if ($user)
            <h1>Добавление ученика в класс {{ $class->name }}</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('addStudentByEmail') }}" method="POST">
                @csrf
                <input type="hidden" name="class_id" value="{{ $class->id }}">
                <div class="form-group">
                    <label for="student-email">Email ученика:</label>
                    <select name="student_email" id="student-email" required>
                        <option value="" selected disabled>Выберите email ученика</option>
                        @foreach ($students as $student)
                            <option value="{{ $student }}">{{ $student }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="add-student-button">Добавить ученика</button>
            </form>
        @else
            <main class="autherror">
                <h1>Пользователь не авторизован</h1>
                <p>Пожалуйста, <a href="{{ route('login') }}">войдите в систему</a>, чтобы добавить ученика.</p>
            </main>
        @endif
    </main>
@endsection
