@extends('layouts.app')

@section('title-block', 'Скачать приложение')

@section('content-block')
    <div class="download">
        <h1>Скачать приложение!</h1>
        <p>Нажмите на кнопку ниже, чтобы загрузить последнюю версию нашего приложения.</p>

        <a href="{{ route('download-app') }}" download>
            <button>Скачать приложение</button>
        </a>
    </div>
@endsection
