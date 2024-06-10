<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShowController extends Controller
{
    // Метод для отображения главной страницы
    public function showHomePage()
    {
        // Возвращаем представление главной страницы
        return view('home');
    }

    // Метод для отображения страницы загрузки
    public function showDownloadPage()
    {
        // Возвращаем представление страницы загрузки
        return view('download');
    }

    // Метод для отображения страницы "О нас"
    public function showAboutPage()
    {
        // Возвращаем представление страницы "О нас"
        return view('about');
    }
}
