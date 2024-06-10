<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Метод для отображения страницы профиля
    public function showProfilePage()
    {
        $userId = session('id');

        $userData = DB::table('teachers')
            ->leftJoin('cities', 'teachers.city_id', '=', 'cities.id')
            ->leftJoin('schools', 'teachers.school_id', '=', 'schools.id')
            ->select('teachers.id', 'teachers.name', 'teachers.patronymic', 'teachers.surname', 'teachers.email',
                'cities.name as city', 'schools.name as school')
            ->where('teachers.id', $userId)
            ->first();

        return view('/profile/profile', ['user' => $userData]);
    }

    // Метод для отображения формы редактирования профиля
    public function showEditForm()
    {
        $userId = session('id');

        $userData = DB::table('teachers')
            ->leftJoin('cities', 'teachers.city_id', '=', 'cities.id')
            ->leftJoin('schools', 'teachers.school_id', '=', 'schools.id')
            ->select('teachers.id', 'teachers.name', 'teachers.patronymic', 'teachers.surname', 'teachers.email',
                'teachers.city_id', 'teachers.school_id')
            ->where('teachers.id', $userId)
            ->first();

        $cities = DB::table('cities')->select('id', 'name')->get();
        $schools = DB::table('schools')->select('id', 'name', 'city_id')->get();

        return view('/profile/edit', [
            'user' => $userData,
            'cities' => $cities,
            'schools' => $schools
        ]);
    }

    // Метод для обновления профиля пользователя
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'patronymic' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email',
            'city_id' => 'nullable|exists:cities,id',
            'school_id' => 'nullable|exists:schools,id',
        ]);

        $userId = session('id');

        DB::table('teachers')
            ->where('id', $userId)
            ->update([
                'name' => $request->name,
                'patronymic' => $request->patronymic,
                'surname' => $request->surname,
                'email' => $request->email,
                'city_id' => $request->city_id,
                'school_id' => $request->school_id,
            ]);

        return redirect()->route('profile-page')->with('success', 'Профиль обновлен успешно');
    }

    // Метод для удаления аккаунта пользователя
    public function deleteAccount()
    {
        $userId = session('id');

        DB::table('teachers')->where('id', $userId)->delete();

        session()->flush();

        return redirect()->route('login-page')->with('success', 'Аккаунт удален успешно');
    }

    // Метод для выхода из системы
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login-page')->with('success', 'Вы успешно вышли из системы.');
    }
}
