@extends('layouts.app')

@section('title-block', 'Детали ученика')

@section('content-block')
    <style>
        .student-details {
            margin: 50px auto;
            max-width: 800px;
            text-align: center;
        }

        .student-details h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
        }

        .back-button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
    @if ($user)
        <main class="student-details">
            <h1>Класс {{ $student->class->name }}: Динамика успеваемости ученика {{ $student->surname }} {{ $student->name }} {{ $student->patronymic }} по дисциплине {{ $tests->first()->subject->name }}</h1>

            <div class="chart-container">
                <canvas id="gradesChart"></canvas>
            </div>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var ctx = document.getElementById('gradesChart').getContext('2d');

                var labels = {!! json_encode($tests->pluck('name')) !!};
                var studentGrades = {!! json_encode($studentGrades) !!};
                var testAverages = {!! json_encode($testAveragesNew) !!};

                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Оценки ученика',
                                data: studentGrades,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 2,
                                fill: false,
                            },
                            {
                                label: 'Средняя оценка по классу',
                                data: testAverages,
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 2,
                                fill: false,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Тесты'
                                }
                            },
                            y: {
                                min: 0,
                                max: 5,
                                ticks: {
                                    stepSize: 1
                                },
                                title: {
                                    display: true,
                                    text: 'Оценки'
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @else
        <main class="autherror">
            <h1>Пользователь не авторизован</h1>
            <p>Пожалуйста, <a href="{{ route('login') }}">войдите в систему</a>, чтобы иметь возможность детали успеваимости ученика.</p>
        </main>
    @endif
@endsection
