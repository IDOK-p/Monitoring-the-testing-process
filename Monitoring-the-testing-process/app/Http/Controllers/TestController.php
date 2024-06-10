<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Subject;
use App\Models\ClassModel;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestAssigned;

class TestController extends Controller
{
    //Метод для отображения страницы со списком тестов.
    public function showTests(Request $request)
    {
        $userId = session('id');
        $user = Teacher::find($userId);
        $errorMessage = '';

        if (empty($user->city_id) || empty($user->school_id)) {
            $errorMessage = 'Пожалуйста, выберите город и школу перед использованием этой страницы.';
            return view('tests.tests', ['user' => $userId], compact('errorMessage'));
        } else {
            $subjectId = $request->input('subject_id');

            $tests = Test::when($subjectId, function ($query) use ($subjectId) {
                return $query->where('subject_id', $subjectId);
            })->get();

            $subjects = Subject::all();

            // Возвращение представления с тестами и предметами
            return view('tests.tests', ['user' => $userId], compact('tests', 'subjects', 'subjectId'));
        }
    }

    //Метод для отображения страницы назначения теста.
    public function assignTest(Request $request, $testId)
    {
        $test = Test::findOrFail($testId);
        $classes = ClassModel::all();

        // Возвращение представления с тестом и классами
        return view('tests.assign', compact('test', 'classes'));
    }

    //Метод для получения списка студентов по классу.
    public function getStudentsByClass($classId)
    {
        $students = Student::where('class_id', $classId)->get();

        // Возвращение списка студентов в формате JSON
        return response()->json($students);
    }

    //Метод для отправки уведомления о назначении теста.
    public function sendTestNotification(Request $request, $testId)
    {
        $test = Test::findOrFail($testId);

        $classId = $request->input('class_id');
        $studentId = $request->input('student_id');

        // Если выбран "все студенты", то получаем всех студентов класса, иначе - конкретного студента
        if ($studentId === 'all') {
            $students = Student::where('class_id', $classId)->get();
        } else {
            $students = Student::where('id', $studentId)->get();
        }

        // Отправка уведомлений по электронной почте каждому студенту
        foreach ($students as $student) {
            try {
                Mail::to($student->email)->send(new TestAssigned($test, $student));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Произошла ошибка при отправке email: ' . $e->getMessage());
            }
        }

        // Перенаправление обратно с сообщением об успешной отправке уведомлений
        return redirect()->back()->with('success', 'Уведомление отправлено.');
    }
}
