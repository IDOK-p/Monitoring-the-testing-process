@extends('layouts.app')

@section('title-block', 'Тесты')

@section('content-block')
    <style>
        .tests {
            max-width: 800px;
            margin: 110px auto;
            padding: 20px;
            border: 1px solid #0056b3;
            border-radius: 8px;
            background-color: #f8f9fa;
            text-align: center;
        }

        .tests h1 {
            font-size: 2em;
            color: #0056b3;
            margin-bottom: 20px;
        }

        .filter-form {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .filter-form label {
            margin-right: 10px;
        }

        .filter-form select {
            padding: 8px;
            font-size: 1em;
        }

        .filter-form button {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }

        .filter-form button:hover {
            background-color: #0056b3;
        }

        .test-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
            text-align: center;
        }

        .test-list li {
            margin-bottom: 10px;
        }

        .test-list li button {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }

        .test-list li button:hover {
            background-color: #0056b3;
        }

        .alert {
            margin: 50px auto;
            padding: 15px;
            color: red;
            margin-bottom: 20px;
        }
    </style>
    <div class="tests">
        @if ($user)
            @if(!empty($errorMessage))
                <div class="alert">
                    {{ $errorMessage }}
                </div>
            @else
                <h1>Список тестов</h1>

                <div class="filter-form">
                    <form action="{{ route('tests-page') }}" method="GET">
                        <label for="subject_id">Фильтр по предмету:</label>
                        <select name="subject_id" id="subject_id">
                            <option value="">Все предметы</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ $subject->id == $subjectId ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                    {{ $subject->surname }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit">Применить</button>
                    </form>
                </div>

                @if($subjectId)
                    @if($tests->isEmpty())
                        <p>Нет доступных тестов по выбранному предмету.</p>
                    @else
                        <ul class="test-list">
                            @foreach($tests as $test)
                                <li>{{ $test->name }} <a href="{{ route('assign-test', ['testId' => $test->id]) }}"><button type="button">Назначить</button></a></li>
                            @endforeach
                        </ul>
                    @endif
                @else
                    <p>Выберите предмет для просмотра тестов.</p>
                @endif
            @endif
        @else
            <main class="autherror">
                <h1>Пользователь не авторизован</h1>
                <p>Пожалуйста, <a href="{{ route('login') }}">войдите в систему</a>, чтобы иметь возможность назначать тесты.</p>
            </main>
        @endif
    </div>
@endsection
