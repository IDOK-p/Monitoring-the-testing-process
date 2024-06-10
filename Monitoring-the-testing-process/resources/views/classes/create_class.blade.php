@extends('layouts.app')

@section('title-block', 'Создание класса')

@section('content-block')
    <main class="class-form">
        @if ($user)
            <h1>Добавление нового класса</h1>
            @if ($errors->any())
                <div class="alert alert-danger" style="color: red">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('storeClass') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="class-name">Название класса:</label>
                    <input type="text" id="class-name" name="class_name" value="{{ old('class_name') }}">
                </div>
                <button type="submit" class="addclass-button">Добавить класс</button>
            </form>
        @else
            <main class="autherror">
                <h1>Пользователь не авторизован</h1>
                <p>Пожалуйста, <a href="{{ route('login') }}">войдите в систему</a>, чтобы увидеть список классов.</p>
            </main>
        @endif
    </main>
@endsection
