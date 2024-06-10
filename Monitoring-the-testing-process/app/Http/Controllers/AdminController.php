<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Метод для отображения страницы профиля администратора
    public function showAdminProfilePage()
    {
        $adminId = session('id');

        $adminData = DB::table('admins')
            ->select('id', 'name', 'patronymic', 'surname', 'email')
            ->where('id', $adminId)
            ->first();

        return view('admin.profile', ['admin' => $adminData]);
    }

    // Метод для отображения формы редактирования профиля администратора
    public function showEditForm()
    {
        $adminId = session('id');

        $adminData = DB::table('admins')
            ->select('id', 'name', 'patronymic', 'surname', 'email')
            ->where('id', $adminId)
            ->first();

        return view('admin.edit', ['admin' => $adminData]);
    }

    // Метод для обновления профиля администратора
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'patronymic' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        $adminId = session('id');

        DB::table('admins')
            ->where('id', $adminId)
            ->update([
                'name' => $request->name,
                'patronymic' => $request->patronymic,
                'surname' => $request->surname,
                'email' => $request->email,
            ]);

        return redirect()->route('admin-profile-page')->with('success', 'Профиль обновлен успешно');
    }

    // Метод для удаления аккаунта администратора
    public function deleteAccount()
    {
        $adminId = session('id');

        DB::table('admins')->where('id', $adminId)->delete();

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

    // Метод для отображения списка городов
    public function showCities()
    {
        $cities = DB::table('cities')->get();
        return view('admin.cities', ['cities' => $cities]);
    }

    // Метод для отображения формы добавления нового города
    public function showAddCityForm()
    {
        return view('admin.add-city');
    }

    // Метод для добавления нового города
    public function storeCity(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^г\. [А-ЯЁ][а-яё]+$/u',
                'unique:cities,name',
            ],
        ], [
            'name.regex' => 'Город должен выводиться в формате: "г. Москва"',
            'name.unique' => 'Город уже добавлен',
        ]);
        DB::table('cities')->insert([
            'name' => $request->name,
        ]);

        return redirect()->route('cities-page')->with('success', 'Город добавлен успешно');
    }

    // Метод для удаления города
    public function deleteCity($id)
    {
        $schoolCount = DB::table('schools')->where('city_id', $id)->count();
        $studentCount = DB::table('students')->where('school_id', $id)->count();
        $teacherCount = DB::table('teachers')->where('school_id', $id)->count();

        if ($schoolCount > 0 || $studentCount > 0 || $teacherCount > 0) {
            return redirect()->route('cities-page')->witherrors(['error' => 'Невозможно удалить город. Сначала удалите все записи, связанные с этим городом.']);
        }

        DB::table('cities')->where('id', $id)->delete();

        return redirect()->route('cities-page')->with('success', 'Город удален успешно');
    }

    // Метод для отображения страницы со списком школ и фильтром
    public function showSchoolsPage(Request $request)
    {
        $cities = DB::table('cities')->get();
        $schools = collect();

        if ($request->has('city')) {
            $cityId = $request->input('city');
            $schools = DB::table('schools')->where('city_id', $cityId)->get();
        }

        return view('admin.schools', ['cities' => $cities, 'schools' => $schools]);
    }

    // Метод для отображения формы добавления школы
    public function showAddSchoolForm($cityId)
    {
        $city = DB::table('cities')->where('id', $cityId)->first();
        return view('admin.add-school', ['city' => $city]);
    }

    // Метод для добавления школы
    public function storeSchool(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|integer|exists:cities,id',
        ]);

        DB::table('schools')->insert([
            'name' => $request->name,
            'city_id' => $request->city_id,
        ]);

        return redirect()->route('schools-page', ['city' => $request->city_id])->with('success', 'Школа добавлена успешно');
    }

    // Метод для удаления школы
    public function deleteSchools(Request $request, $id)
    {

        $studentCount = DB::table('students')->where('school_id', $id)->count();
        $teacherCount = DB::table('teachers')->where('school_id', $id)->count();

        if ($studentCount > 0 || $teacherCount > 0) {
            return redirect()->route('schools-page')->witherrors(['error' => 'Невозможно удалить школу. Сначала удалите все записи, связанные с этой школой.']);
        }

        DB::table('schools')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Школа успешно удалена');
    }

    // Метод для отображения страницы со списком администраторов
    public function showAdminsPage()
    {
        $admins = DB::table('admins')->get();
        return view('admin.admins', ['admins' => $admins]);
    }

    // Метод для отображения формы добавления нового администратора
    public function showAddAdminForm()
    {
        return view('admin.add-admin');
    }

    // Метод для добавления нового администратора
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'patronymic' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::table('admins')->insert([
            'name' => $request->name,
            'patronymic' => $request->patronymic,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admins-page')->with('success', 'Администратор успешно добавлен');
    }

    // Метод для удаления администратора
    public function deleteAdmin($id)
    {
        DB::table('admins')->where('id', $id)->delete();
        return redirect()->route('admins-page')->with('success', 'Администратор успешно удален');
    }

    // Метод для отображения страницы со списком учителей
    public function showTeachers()
    {
        $teachers = DB::table('teachers')->get();
        return view('admin.teachers', ['teachers' => $teachers]);
    }

    // Метод для отображения формы добавления нового учителя
    public function showAddTeacherForm()
    {
        $cities = DB::table('cities')->get();
        $schools = DB::table('schools')->get();
        return view('admin.add-teacher', ['cities' => $cities, 'schools' => $schools]);
    }

    // Метод для добавления нового учителя
    public function storeTeacher(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'patronymic' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'password' => 'required|string|min:8|confirmed',
            'city_id' => 'required|integer|exists:cities,id',
            'school_id' => 'required|integer|exists:schools,id',
        ]);

        DB::table('teachers')->insert([
            'name' => $request->name,
            'patronymic' => $request->patronymic,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'city_id' => $request->city_id,
            'school_id' => $request->school_id,
        ]);

        return redirect()->route('teachers-page')->with('success', 'Учитель успешно добавлен');
    }

    // Метод для удаления учителя
    public function deleteTeacher($id)
    {
        DB::table('teachers')->where('id', $id)->delete();
        return redirect()->route('teachers-page')->with('success', 'Учитель успешно удален');
    }

    // Метод для отображения страницы со списком учеников
    public function showStudents()
    {
        $students = DB::table('students')->get();
        return view('admin.students', ['students' => $students]);
    }

    // Метод для отображения формы добавления нового ученика
    public function showAddStudentForm()
    {
        $cities = DB::table('cities')->get();
        $schools = DB::table('schools')->get();
        $classes = DB::table('classes')->get();
        return view('admin.add-student', ['cities' => $cities, 'schools' => $schools, 'classes' => $classes]);
    }

    // Метод для добавления нового ученика
    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'patronymic' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'city_id' => 'required|integer|exists:cities,id',
            'school_id' => 'required|integer|exists:schools,id',
            'class_id' => 'required|integer|exists:classes,id',
        ]);

        DB::table('students')->insert([
            'name' => $request->name,
            'patronymic' => $request->patronymic,
            'surname' => $request->surname,
            'email' => $request->email,
            'city_id' => $request->city_id,
            'school_id' => $request->school_id,
            'class_id' => $request->class_id,
        ]);

        return redirect()->route('students-page')->with('success', 'Ученик успешно добавлен');
    }

    // Метод для удаления ученика
    public function deleteStudent($id)
    {
        DB::table('students')->where('id', $id)->delete();
        return redirect()->route('students-page')->with('success', 'Ученик успешно удален');
    }

    // Метод для отображения формы редактирования данных администратора
    public function showEditAdminForm($id)
    {
        $admin = DB::table('admins')->where('id', $id)->first();
        return view('admin.edit-admin', ['admin' => $admin]);
    }

    // Метод для обновления данных администратора
    public function updateAdmin(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'patronymic' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        DB::table('admins')->where('id', $id)->update([
            'name' => $request->name,
            'patronymic' => $request->patronymic,
            'surname' => $request->surname,
            'email' => $request->email,
        ]);

        return redirect()->route('admins-page')->with('success', 'Данные администратора обновлены успешно');
    }

    // Метод для отображения формы редактирования данных учителя
    public function showEditTeacherForm($id)
    {
        $teacher = DB::table('teachers')->where('id', $id)->first();
        $cities = DB::table('cities')->get();
        $schools = DB::table('schools')->get();
        return view('admin.edit-teacher', ['teacher' => $teacher, 'cities' => $cities, 'schools' => $schools]);
    }

    // Метод для обновления данных учителя
    public function updateTeacher(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'patronymic' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email',
            'city_id' => 'required|integer|exists:cities,id',
            'school_id' => 'required|integer|exists:schools,id',
        ]);

        DB::table('teachers')->where('id', $id)->update([
            'name' => $request->name,
            'patronymic' => $request->patronymic,
            'surname' => $request->surname,
            'email' => $request->email,
            'city_id' => $request->city_id,
            'school_id' => $request->school_id,
        ]);

        return redirect()->route('teachers-page')->with('success', 'Данные учителя обновлены успешно');
    }

    // Метод для отображения формы редактирования данных ученика
    public function showEditStudentForm($id)
    {
        $student = DB::table('students')->where('id', $id)->first();
        $cities = DB::table('cities')->get();
        $schools = DB::table('schools')->get();
        $classes = DB::table('classes')->get();
        return view('admin.edit-student', ['student' => $student, 'cities' => $cities, 'schools' => $schools, 'classes' => $classes]);
    }

    // Метод для обновления данных ученика
    public function updateStudent(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'patronymic' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email',
            'city_id' => 'required|integer|exists:cities,id',
            'school_id' => 'required|integer|exists:schools,id',
            'class_id' => 'required|integer|exists:classes,id',
        ]);

        DB::table('students')->where('id', $id)->update([
            'name' => $request->name,
            'patronymic' => $request->patronymic,
            'surname' => $request->surname,
            'email' => $request->email,
            'city_id' => $request->city_id,
            'school_id' => $request->school_id,
            'class_id' => $request->class_id,
        ]);

        return redirect()->route('students-page')->with('success', 'Данные ученика обновлены успешно');
    }
}
