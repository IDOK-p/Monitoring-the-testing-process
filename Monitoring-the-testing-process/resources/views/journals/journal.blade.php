@extends('layouts.app')

@section('title-block', 'Журнал')

@section('content-block')
    <style>
        .journal {
            margin: 20px auto;
            max-width: 950px;
            text-align: center;
        }

        .journal h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .journal form {
            margin-bottom: 20px;
            text-align: center;
        }

        .journal form div {
            margin-bottom: 10px;
            display: flex;
            justify-content: center;
        }

        .journal label {
            font-weight: bold;
            margin-right: 10px;
            flex: 1;
            text-align: right;
        }

        .journal select, input[type="date"], button {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 14px;
            flex: 1;
        }

        .journal button {
            display: block;
            margin-top: 10px;
            background-color: #0059b9;
            color: #fff;
            cursor: pointer;
            width: 25%;
            height: 30px;
            margin: 10px auto;
        }

        .journal button:hover {
            background-color: #0056b3;
        }

        .journal .journal-table-container {
            max-height: 340px;
            overflow-y: auto;
            border: 1px solid #ccc;
            margin-bottom: 0px;
        }

        .journal .journal-table {
            border-collapse: collapse;
            width: 100%;
            margin: 0 auto ;
        }

        .journal .journal-table th, .journal-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .journal .journal-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .journal.journal-table td {
            text-align: center;
        }

        .journal-table td.low-average {
            background-color: #ffb3b3;
        }

        .journal-table td.high-average {
            background-color: #b3ffb3;
        }

        .journal-table tbody tr:nth-last-child(-n+2) {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }

        .btn-download-excel {
            display: block;
            margin-top: 20px;
            background-color: #0059b9;
            color: #fff;
            cursor: pointer;
            width: 25%;
            height: 20px;
            margin: 20px auto 0;
            text-align: center;
            padding: 10px;
            border-radius: 3px;
            text-decoration: none;
        }

        .btn-download-excel:hover {
            background-color: #0056b3;
        }

        .alert {
            margin: 200px auto;
            padding: 15px;
            color: red;
            margin-bottom: 20px;
        }
    </style>

    <main class="journal">
        @if ($user)
            @if(!empty($errorMessage))
                <div class="alert">
                    {{ $errorMessage }}
                </div>
            @else
                <h1>
                    @if(isset($selectedClass) && isset($selectedSubject))
                        Журнал класса {{ $selectedClass->name }} по дисциплине {{ $selectedSubject->name }}
                    @else
                        Журнал
                    @endif
                </h1>

                <form action="{{ route('journal-filter') }}" method="post">
                    @csrf
                    <div>
                        <label for="class_id">Класс:</label>
                        <select name="class_id" id="class_id">
                            <option value="">Выберите класс</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ (isset($selectedClass) && $selectedClass->id == $class->id) ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>

                        <label for="subject_id">Предмет:</label>
                        <select name="subject_id" id="subject_id">
                            <option value="">Выберите предмет</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ (isset($selectedSubject) && $selectedSubject->id == $subject->id) ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="date_from">Дата с:</label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}">

                        <label for="date_to">Дата по:</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}">
                    </div>

                    <button type="submit">Применить</button>
                </form>

                @if(empty($students) || empty($tests))
                    @if(empty($students))
                        <p>Выберите класс</p>
                    @endif
                    @if(empty($tests))
                        <p>Выберите предмет</p>
                    @endif
                @else
                    <div class="journal-table-container">
                        <table class="journal-table">
                            <thead>
                                <tr>
                                    <th>Ученик</th>
                                    @foreach($tests as $test)
                                        <th>{{ $test->name }} </th>
                                    @endforeach
                                    <th>Средний балл за период</th>
                                    <th>Динамика</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students->sortBy(['surname', 'name', 'patronymic']) as $student)
                                    <tr>
                                        <td>{{ $student->surname }} {{ $student->name }} {{ $student->patronymic }}</td>
                                        @foreach($tests as $test)
                                            <td>
                                                @foreach($grades as $grade)
                                                    @if($grade->student_id == $student->id && $grade->test_id == $test->id)
                                                        {{ $grade->grade }}
                                                    @endif
                                                @endforeach
                                            </td>
                                        @endforeach
                                        <td>{{ $studentAverages[$student->id] }}</td>
                                        <td>
                                            <a href="{{ route('student-details', ['student' => $student->id,
                                                'testAverages' => $testAverages,
                                                'class_id' => $class->id,
                                                'subject_id' => request('subject_id'), 'date_from' => request('date_from'),
                                                'date_to' => request('date_to')]) }}">
                                                подробнее
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>Средний балл за тест</td>
                                    @foreach($tests as $test)
                                        <td>{{ $testAverages[$test->id] }}</td>
                                    @endforeach
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Статистика по тестам</td>
                                    @foreach($tests as $test)
                                    <td>
                                        <a href="{{ route('test-statistics', ['testId' => $test->id, 'class_id' => $selectedClass->id, 'subject_id' => $selectedSubject->id]) }}">подробнее</a>
                                    </td>
                                    @endforeach
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <a href="{{ route('journal.export', [
                    'class_id' => request('class_id'),
                    'subject_id' => request('subject_id'),
                    'date_from' => request('date_from'),
                    'date_to' => request('date_to')
                ]) }}" class="btn-download-excel">Скачать в Excel</a>
                @endif
            @endif
        @else
            <main class="autherror">
                <h1>Пользователь не авторизован</h1>
                <p>Пожалуйста, <a href="{{ route('login') }}">войдите в систему</a>, чтобы иметь возможность просматривать журнал.</p>
            </main>
        @endif
    </main>
@endsection
