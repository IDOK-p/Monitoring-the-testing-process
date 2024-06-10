@extends('layouts.app')

@section('title-block', 'Добавить город')

@section('content-block')
    <style>
        .add-city-form {
            max-width: 600px;
            margin: 160px auto;
            padding: 20px;
            border: 1px solid #0056b3;
            border-radius: 8px;
            background-color: #f8f9fa;
        }
        .add-city-form h2 {
            font-size: 2em;
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
        }
        .add-city-form input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            color: #333;
            margin-bottom: 15px;
        }
        .add-city-form button.add {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .add-city-form button.add:hover {
            background-color: #0056b3;
        }
    </style>

    <div class="add-city-form">
        <h2>Добавить город</h2>
        @if (session('success'))
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
        <form action="{{ route('store-city') }}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="Название города" required>
            <button type="submit" class="add">Добавить</button>
        </form>
    </div>
@endsection
