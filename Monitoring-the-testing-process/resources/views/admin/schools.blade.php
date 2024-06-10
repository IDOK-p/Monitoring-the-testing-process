@extends('layouts.app')

@section('title-block', 'Школы')

@section('content-block')
    <style>
        .school-list {
            max-width: 800px;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f8f9fa;
        }

        .school-list h1 {
            font-size: 24px;
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
        }

        .city-filter {
            margin-bottom: 20px;
            text-align: center;
        }

        .city-filter label {
            margin-right: 10px;
        }

        .city-filter select {
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .city-filter button[type="submit"] {
            padding: 8px 16px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .city-filter button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .add-school {
            margin-top: 20px;
            text-align: center;
        }

        .add-school a {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-school a:hover {
            background-color: #218838;
        }

        #school-list {
            list-style: none;
            padding: 0;
        }

        #school-list li {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }


        .delete-school {
            float: right;
            margin-left: 10px;
        }

        .delete-school form {
            display: inline;
        }

        .delete-school button[type="submit"] {
            padding: 4px 8px;
            font-size: 14px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .delete-school button[type="submit"]:hover {
            background-color: #c82333;
        }

    </style>

    <div class="school-list">
        <h1>Школы</h1>
        @if(session('success'))
            <div style="color: green; margin-bottom: 20px; text-align: center;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="color: red; margin-bottom: 20px; text-align: center;">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif
        <!-- Форма для выбора города -->
        <form method="GET" action="{{ route('schools-page') }}" class="city-filter">
            <label for="city-select">Выберите город:</label>
            <select id="city-select" name="city">
                <option value="">Выберите город</option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" {{ request('city') == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit">Применить</button>
        </form>

        <!-- Список школ -->
        <ul id="school-list">
            @if(request('city'))
                @if($schools->isEmpty())
                    <li>В этом городе нет школ</li>
                @else
                    @foreach($schools as $school)
                        <li>{{ $school->name }}
                            <span class="delete-school">
                                <form action="{{ route('delete-school', ['id' => $school->id]) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту школу?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Удалить</button>
                                </form>
                            </span>
                        </li>
                    @endforeach
                @endif
            @else
                <li>Выберите город для отображения школ</li>
            @endif
        </ul>

        <!-- Кнопка для добавления школы -->
        @if(request('city'))
            <div class="add-school">
                <a href="{{ route('add-school-form', ['city' => request('city')]) }}">Добавить школу</a>
            </div>
        @endif
    </div>
@endsection
