@extends('layouts.app')

@section('title-block', 'Назначить тест')

@section('content-block')
    <style>
        .assign-test {
            max-width: 800px;
            margin: 110px auto;
            padding: 20px;
            border: 1px solid #0056b3;
            border-radius: 8px;
            background-color: #f8f9fa;
            text-align: center;
        }

        .assign-test h1 {
            font-size: 2em;
            color: #0056b3;
            margin-bottom: 20px;
        }

        .assign-test form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .assign-test label {
            margin-top: 10px;
            font-weight: bold;
        }

        .assign-test select {
            padding: 8px;
            font-size: 1em;
            margin-top: 5px;
            margin-bottom: 20px;
            width: 100%;
            max-width: 400px;
        }

        .assign-test button {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .assign-test button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        .assign-test button:not(:disabled):hover {
            background-color: #0056b3;
        }

        .assign-test #error-message {
            color: red;
            margin-top: 10px;
            display: none;
        }
    </style>
    <div class="assign-test">
        <h1>Назначить тест: {{ $test->name }}</h1>

        @if (session('error'))
            <div style="color: red;">{{ session('error') }}</div>
        @endif

        @if (session('success'))
            <div style="color: green;">{{ session('success') }}</div>
        @endif

        <form id="assign-form" action="{{ route('sendTestNotification', $test->id) }}" method="POST">
            @csrf
            <label for="class_id">Класс:</label>
            <select name="class_id" id="class_id">
                <option value="">Выберите класс</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>

            <label for="student_id">Ученик:</label>
            <select name="student_id" id="student_id" disabled>
                <option value="">Сначала выберите класс</option>
                <option value="all">Все ученики</option>
            </select>

            <div id="error-message">Выберите класс и ученика.</div>

            <button type="submit">Назначить</button>
        </form>
    </div>

    <script>
        document.getElementById('class_id').addEventListener('change', function () {
            var classId = this.value;
            var studentSelect = document.getElementById('student_id');

            studentSelect.innerHTML = '<option value="">Загрузка...</option>';
            studentSelect.disabled = true;

            if (classId) {
                fetch(`/students/${classId}`)
                    .then(response => response.json())
                    .then(data => {
                        studentSelect.innerHTML = '<option value="">Выберите ученика</option>';
                        studentSelect.innerHTML += '<option value="all">Все ученики</option>';
                        data.sort((a, b) => a.surname.localeCompare(b.surname)).forEach(student => {
                            var option = document.createElement('option');
                            option.value = student.id;
                            option.textContent = student.surname + ' ' + student.name + ' ' + student.patronymic;
                            studentSelect.appendChild(option);
                        });
                        studentSelect.disabled = false;
                    })
                    .catch(error => {
                        studentSelect.innerHTML = '<option value="">Ошибка загрузки</option>';
                    });
            } else {
                studentSelect.innerHTML = '<option value="">Сначала выберите класс</option>';
                studentSelect.disabled = true;
            }
        });

        document.getElementById('student_id').addEventListener('change', function () {
            var classId = document.getElementById('class_id').value;
            var studentId = this.value;
            var assignButton = document.querySelector('form button[type="submit"]');
            var errorMessage = document.getElementById('error-message');

            if (classId && studentId) {
                assignButton.disabled = false;
                errorMessage.style.display = 'none';
            } else {
                assignButton.disabled = true;
                errorMessage.style.display = 'block';
            }
        });

        document.getElementById('assign-form').addEventListener('submit', function (event) {
            var classId = document.getElementById('class_id').value;
            var studentId = document.getElementById('student_id').value;
            var errorMessage = document.getElementById('error-message');

            if (!classId || !studentId) {
                event.preventDefault();
                errorMessage.style.display = 'block';
            } else {
                errorMessage.style.display = 'none';
            }
        });
    </script>
@endsection
