@extends('layouts.app')

@section('title-block', 'Статистика по тестам')

@section('content-block')
    @if ($user)
        <h1 style="text-align: center; font-size: 20px;">Статистика по тесту "{{ $test->name }}"</h1>

        <canvas id="gradeChart" width="1000" height="350" style="margin: 0 auto;"></canvas>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Отобразим статистику по тесту в виде графика
            var gradeCounts = {!! json_encode($gradeCounts) !!};

            var ctx = document.getElementById('gradeChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['5', '4', '3', '2'],
                    datasets: [{
                        label: 'Количество оценок',
                        data: [
                            gradeCounts['5'],
                            gradeCounts['4'],
                            gradeCounts['3'],
                            gradeCounts['2']
                        ],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        </script>

        <div class="tables-container">
            <div class="table-wrapper">
                <h2>Ученики, получившие 5</h2>
                <table class="table table-bordered" style="background-color: rgba(255, 99, 132, 0.2);">
                    <thead>
                        <tr>
                            <th>Фамилия</th>
                            <th>Имя</th>
                            <th>Отчество</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($studentsByGrade['5']) > 0)
                            @foreach ($studentsByGrade['5'] as $student)
                                <tr>
                                    <td>{{ $student->surname }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->patronymic }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td style="text-align: center;">-</td>
                                <td style="text-align: center;">-</td>
                                <td style="text-align: center;">-</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="table-wrapper">
                <h2>Ученики, получившие 4</h2>
                <table class="table table-bordered" style="background-color: rgba(54, 162, 235, 0.2);">
                    <thead>
                        <tr>
                            <th>Фамилия</th>
                            <th>Имя</th>
                            <th>Отчество</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($studentsByGrade['4']) > 0)
                            @foreach ($studentsByGrade['4'] as $student)
                                <tr>
                                    <td>{{ $student->surname }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->patronymic }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td style="text-align: center;">-</td>
                                <td style="text-align: center;">-</td>
                                <td style="text-align: center;">-</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="table-wrapper">
                <h2>Ученики, получившие 3</h2>
                <table class="table table-bordered" style="background-color: rgba(255, 206, 86, 0.2);">
                    <thead>
                        <tr>
                            <th>Фамилия</th>
                            <th>Имя</th>
                            <th>Отчество</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($studentsByGrade['3']) > 0)
                            @foreach ($studentsByGrade['3'] as $student)
                                <tr>
                                    <td>{{ $student->surname }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->patronymic }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td style="text-align: center;">-</td>
                                <td style="text-align: center;">-</td>
                                <td style="text-align: center;">-</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="table-wrapper">
                <h2>Ученики, получившие 2</h2>
                <table class="table table-bordered" style="background-color: rgba(75, 192, 192, 0.2);">
                    <thead>
                        <tr>
                            <th>Фамилия</th>
                            <th>Имя</th>
                            <th>Отчество</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($studentsByGrade['2']) > 0)
                            @foreach ($studentsByGrade['2'] as $student)
                                <tr>
                                    <td>{{ $student->surname }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->patronymic }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td style="text-align: center;">-</td>
                                <td style="text-align: center;">-</td>
                                <td style="text-align: center;">-</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <main class="autherror">
            <h1>Пользователь не авторизован</h1>
            <p>Пожалуйста, <a href="{{ route('login') }}">войдите в систему</a>, чтобы иметь возможность детали успеваимости по тесту.</p>
        </main>
    @endif
    <style>
        .tables-container {
            display: flex;
            flex-wrap: nowrap;
            justify-content: center;
            gap: 20px;
        }

        .table-wrapper {
            width: 20%;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }
    </style>
@endsection
