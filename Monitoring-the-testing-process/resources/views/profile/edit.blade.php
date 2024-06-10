@extends('layouts.app')

@section('title-block')
    Редактировать профиль
@endsection

@section('content-block')
    <div class="profile-edit">
        @if ($user)
            <h2>Редактировать профиль</h2>

            <form method="POST" action="{{ route('update-profile') }}">
                @csrf

                <div class="columns">
                    <div class="column">
                        <div class="form-group">
                            <label for="name">Имя</label>
                            <input type="text" name="name" value="{{ $user->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="patronymic">Отчество</label>
                            <input type="text" name="patronymic" value="{{ $user->patronymic }}" required>
                        </div>
                        <div class="form-group">
                            <label for="surname">Фамилия</label>
                            <input type="text" name="surname" value="{{ $user->surname }}" required>
                        </div>
                    </div>
                    <div class="column">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" required>
                        </div>
                        <div class="form-group">
                            <label for="city_id">Город</label>
                            <select name="city_id" id="city_id" required>
                                <option value="">Выберите город</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" @if($user->city_id == $city->id) selected @endif>{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="school_id">Школа</label>
                            <select name="school_id" id="school_id" required>
                                <option value="">Выберите школу</option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}" @if($user->school_id == $school->id) selected @endif data-city-id="{{ $school->city_id }}">{{ $school->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            </form>
        @else
            <main class="autherror">
                <h1>Пользователь не авторизован</h1>
                <p>Пожалуйста, <a href="{{ route('login') }}">войдите в систему</a>, чтобы иметь возможность редактировать профиль.</p>
            </main>
        @endif
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
