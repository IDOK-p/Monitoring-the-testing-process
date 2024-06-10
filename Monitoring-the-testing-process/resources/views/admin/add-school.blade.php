@extends('layouts.app')

@section('title-block', 'Добавить школу')

@section('content-block')
    <style>
        .add-school-form {
            max-width: 400px;
            margin: 150px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f8f9fa;
        }

        .add-school-form h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            color: #007bff;
        }

        .add-school-form .form-group {
            margin-bottom: 20px;
        }

        .add-school-form label {
            display: block;
            margin-bottom: 5px;
            color: #495057;
        }

        .add-school-form input[type="text"] {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .add-school-form button[type="submit"] {
            width: 100%;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-school-form button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
    <div class="add-school-form">
        <h1>Добавить школу в {{ $city->name }}</h1>
        <form method="POST" action="{{ route('store-school') }}">
            @csrf
            <div class="form-group">
                <label for="name">Название школы:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <input type="hidden" name="city_id" value="{{ $city->id }}">
            <button type="submit">Добавить</button>
        </form>
    </div>
@endsection
