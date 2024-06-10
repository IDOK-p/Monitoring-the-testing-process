@extends('layouts.app')

@section('title-block', 'Классы')

@section('content-block')
    <style>
        .alert {
            margin: 50px auto;
            padding: 15px;
            color: red;
            margin-bottom: 20px;
        }
    </style>
    <main class="class-form">
        @if ($user)
            @if(!empty($errorMessage))
                <div class="alert">
                    {{ $errorMessage }}
                </div>
            @else
                <h1>Перечень классов</h1>
                <ul>
                    @foreach($classes as $class)
                        <li><a href="{{ route('showClassDetails', $class->id) }}" class="class-button">{{ $class->name }}</a></li>
                    @endforeach
                </ul>
                <a href="{{ route('showClassCreate') }}" class="add-class-button">Добавить класс</a>
            @endif
        @else
            <main class="autherror">
                <h1>Пользователь не авторизован</h1>
                <p>Пожалуйста, <a href="{{ route('login') }}">войдите в систему</a>, чтобы увидеть список классов.</p>
            </main>
        @endif
    </main>
@endsection
