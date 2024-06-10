@extends('layouts.app')

@section('title-block', 'Редактировать учителя')

@section('content-block')
    <style>
        .container {
            max-width: 600px;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f8f9fa;
        }

        .container h2 {
            font-size: 1.5em;
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
        }

        .container form {
            display: flex;
            flex-direction: column;
        }

        .container label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .container input[type="text"],
        .container input[type="email"],
        .container select {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }

        .container button[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
        }

        .container button[type="submit"]:hover {
            background-color: #0056b3;
        }

    </style>
    <div class="container">
        <h2>Редактировать учителя</h2>
        @if ($errors->any())
            <div style="color: red; margin-bottom: 20px; text-align: center;">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif
        <form action="{{ route('update-teacher', $teacher->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label for="name">Имя</label>
            <input type="text" name="name" id="name" value="{{ $teacher->name }}" required>

            <label for="patronymic">Отчество</label>
            <input type="text" name="patronymic" id="patronymic" value="{{ $teacher->patronymic }}" required>

            <label for="surname">Фамилия</label>
            <input type="text" name="surname" id="surname" value="{{ $teacher->surname }}" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ $teacher->email }}" required>

            <label for="city_id">Город</label>
            <select name="city_id" id="city_id" required>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" {{ $teacher->city_id == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>

            <label for="school_id">Школа</label>
            <select name="school_id" id="school_id" required>
                <option value="">Выберите школу</option>
                @foreach($schools as $school)
                    <option value="{{ $school->id }}" {{ $teacher->school_id == $school->id ? 'selected' : '' }} data-city-id="{{ $school->city_id }}">
                        {{ $school->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit">Сохранить изменения</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const citySelect = document.getElementById('city_id');
            const schoolSelect = document.getElementById('school_id');
            const schools = Array.from(schoolSelect.options);

            function filterSchools() {
                const selectedCityId = citySelect.value;

                schoolSelect.innerHTML = '<option value="">Выберите школу</option>';

                schools.forEach(school => {
                    if (!selectedCityId || school.getAttribute('data-city-id') == selectedCityId) {
                        schoolSelect.appendChild(school);
                    }
                });

                schoolSelect.value = "";
            }

            citySelect.addEventListener('change', filterSchools);

            filterSchools();
        });
    </script>
@endsection
