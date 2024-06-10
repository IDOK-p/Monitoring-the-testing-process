@component('mail::message')
# Назначен тест

Здравствуйте, {{ $studentName }}.

Вам назначен тест: {{ $testName }}.

@component('mail::button', ['url' => url('/tests/'.$test->id)])
Пройти тест
@endcomponent

Спасибо,<br>
{{ config('app.name') }}
@endcomponent
