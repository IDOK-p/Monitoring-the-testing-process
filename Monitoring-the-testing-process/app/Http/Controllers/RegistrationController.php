<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    // Метод для отображения страницы регистрации
    public function showRegistrationPage()
    {
        return view('auth.register');
    }

    // Метод для обработки регистрации пользователя
    public function register(Request $request)
    {
        // Валидация данных
        $request->validate([
            'name' => 'required|string|max:255',
            'patronymic' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:teachers,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Поле "Имя" обязательно для заполнения.',
            'patronymic.required' => 'Поле "Отчество" обязательно для заполнения.',
            'surname.required' => 'Поле "Фамилия" обязательно для заполнения.',
            'email.required' => 'Поле "Email" обязательно для заполнения.',
            'email.email' => 'Введите корректный адрес электронной почты.',
            'email.unique' => 'Этот адрес электронной почты уже занят.',
            'password.required' => 'Поле "Пароль" обязательно для заполнения.',
            'password.min' => 'Пароль должен содержать не менее :min символов.',
            'password.confirmed' => 'Пароли не совпадают.',
        ]);

        // Хеширование пароля
        $hashedPassword = bcrypt($request->password);

        // Вставка данных нового пользователя в базу данных
        DB::table('teachers')->insert([
            'name' => $request->name,
            'patronymic' => $request->patronymic,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => $hashedPassword,
        ]);

        // Редирект на страницу после регистрации или обратно к форме с ошибками
        return redirect()->route('login-page');
    }
}

