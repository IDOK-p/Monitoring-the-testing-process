<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Метод для отображения страницы входа
    public function showLoginPage()
    {
        // Возвращает представление страницы входа
        return view('auth.login');
    }

    // Метод для обработки аутентификации пользователя
    public function login(Request $request)
    {
        // Извлечение данных из запроса
        $email = $request->input('email');
        $password = $request->input('password');

        // Поиск пользователя в таблице teachers
        $user = DB::table('teachers')->where('email', $email)->first();

        // Проверка наличия пользователя и сравнение хешированного пароля
        if ($user && Hash::check($password, $user->password)) {
            // Аутентификация успешна, добавляем информацию о пользователе в сессию
            session()->put('id', $user->id);
            session()->put('name', $user->name);
            session()->put('patronymic', $user->patronymic);
            session()->put('surname', $user->surname);
            session()->put('email', $user->email);
            session()->put('city_id', $user->city_id);
            session()->put('school_id', $user->school_id);
            session()->put('user_type', 'teacher');

            // Перенаправляем пользователя на его профиль
            return redirect()->route('profile-page');
        }

        // Поиск пользователя в таблице admins
        $admin = DB::table('admins')->where('email', $email)->first();

        // Проверка наличия администратора и сравнение хешированного пароля
        if ($admin && Hash::check($password, $admin->password)) {
            // Аутентификация успешна, добавляем информацию об админе в сессию
            session()->put('id', $admin->id);
            session()->put('name', $admin->name);
            session()->put('patronymic', $admin->patronymic);
            session()->put('surname', $admin->surname);
            session()->put('email', $admin->email);
            session()->put('user_type', 'admin');

            // Перенаправляем администратора на пустую страницу
            return redirect()->route('admin-profile-page');
        }

        // Аутентификация не удалась, возвращаем пользователя на страницу входа с ошибкой
        return back()->withErrors(['email' => 'Неверный адрес электронной почты или пароль.'])->withInput($request->only('email'));
    }
}

