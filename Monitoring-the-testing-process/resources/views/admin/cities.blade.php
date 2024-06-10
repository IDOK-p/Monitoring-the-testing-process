@extends('layouts.app')

@section('title-block', 'Города')

@section('content-block')
    <style>
        .city-list {
            max-width: 800px;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #0056b3;
            border-radius: 8px;
            background-color: #f8f9fa;
        }
        .city-list h2 {
            font-size: 2em;
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
        }
        .city-list ul {
            list-style: none;
            padding: 0;
        }
        .city-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        .city-list li form {
            display: inline-block;
        }
        .city-list button.delete-city {
            padding: 5px 10px;
            font-size: 0.9em;
            color: white;
            background-color: #dc3545;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .city-list button.delete-city:hover {
            background-color: #c82333;
        }
        .city-list a.add-city {
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
        .city-list a.add-city:hover {
            background-color: #0056b3;
        }
    </style>

    <div class="city-list">
        <h2>Список городов</h2>
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



        <ul>
            @foreach($cities as $city)
                <li>
                    {{ $city->name }}
                    <form action="{{ route('delete-city', $city->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этот город?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-city">Удалить</button>
                    </form>
                </li>
            @endforeach
        </ul>
        <a href="{{ route('add-city-page') }}" class="add-city">Добавить город</a>
    </div>
@endsection
