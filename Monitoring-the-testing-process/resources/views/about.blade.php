@extends('layouts.app')

@section('title-block', 'Главная')

@section('content-block')
    <div class="about">
        <h1>О нас</h1>
        <p>Web-систему для мониторинга процесса тестирования школьников разработала
            команда высококвалифицированных специалистов в области информационных
            технологий и образования. Мы объединяем опыт в разработке программного
            обеспечения и глубокое понимание потребностей образовательного процесса.
            Наша цель — предоставить современный инструмент, который поможет учителям
            создать благоприятную и продуктивную учебную среду.
            Мы постоянно работаем над совершенствованием нашей системы,
            учитывая отзывы пользователей и внедряя инновационные решения.</p>
        <p>Наши контакты:
            <a href="https://vk.com/lbvfzgjytw">
                <img src="{{ asset('images/vk.png') }}" alt="VK" style="width: 15px; height: 15px;">
            </a>
            <a href="https://t.me/KolobkovDmitrii">
                <img src="{{ asset('images/telegram.png') }}" alt="Telegram" style="width: 15px; height: 15px;">
            </a>
        </p>
    </div>
@endsection