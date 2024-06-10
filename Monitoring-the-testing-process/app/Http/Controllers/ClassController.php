<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\ClassModel;
    use App\Models\Student;
    use App\Models\Teacher;

    class ClassController extends Controller
    {
        // Отображение страницы со списком классов
        public function showClassPage()
        {
            $userId = session('id');
            $user = Teacher::find($userId);
            $errorMessage = '';
            if (empty($user->city_id) || empty($user->school_id)) {
                $errorMessage = 'Пожалуйста, выберите город и школу перед использованием этой страницы.';
                return view('classes.class', ['user' => $userId], compact('errorMessage'));
            } else {
                $classes = ClassModel::all();
                return view('classes.class', ['classes' => $classes, 'user' => $userId]);
            }
        }

        // Отображение детальной информации о классе
        public function showClassDetails($id)
        {
            $userId = session('id');
            $class = ClassModel::findOrFail($id);
            $students = Student::where('class_id', $id)->get();
            return view('classes.details', ['class' => $class, 'students' => $students, 'user' => $userId]);
        }

        // Отображение формы для создания нового класса
        public function showClassCreate()
        {
            $userId = session('id');
            return view('classes.create_class', ['user' => $userId]);
        }

        // Обработка запроса на создание нового класса
        public function store(Request $request)
        {
            // Валидация данных запроса
            $request->validate([
                'class_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9А-Яа-яЁё]+$/u', 'unique:classes,name'],
            ], [
                'class_name.required' => 'Название класса обязательно для заполнения.',
                'class_name.string' => 'Название класса должно быть строкой.',
                'class_name.max' => 'Название класса не должно превышать 255 символов.',
                'class_name.regex' => 'Название класса должно состоять только из букв и цифр.',
                'class_name.unique' => 'Класс с таким названием уже существует.',
            ]);

            // Создание нового класса
            ClassModel::create([
                'name' => $request->class_name,
            ]);

            // Перенаправление на страницу классов с сообщением об успехе
            return redirect()->route('class-page')->with('success', 'Класс успешно добавлен.');
        }

        // Удаление ученика из класса
        public function deleteStudent($id)
        {
            $student = Student::findOrFail($id);
            $student->class_id = null;
            $student->save();

            return redirect()->back()->with('success', 'Ученик успешно удален из класса.');
        }

        // Удаление класса
        public function deleteClass($id)
        {
            $class = ClassModel::findOrFail($id);
            $class->students()->update(['class_id' => null]);
            $class->delete();

            return redirect()->route('class-page')->with('success', 'Класс успешно удален.');
        }

        // Отображение формы для добавления ученика в класс
        public function showAddStudentForm(ClassModel $class)
        {
            $userId = session('id');
            $students = Student::pluck('email');
            return view('classes.add_student', ['class' => $class, 'user' => $userId, 'students' => $students]);
        }

        // Обработка запроса на добавление ученика в класс по email
        public function addStudentByEmail(Request $request)
        {
            // Валидация данных запроса
            $request->validate([
                'student_email' => 'required|email|exists:students,email',
                'class_id' => 'required|exists:classes,id',
            ]);

            $student = Student::where('email', $request->student_email)->first(); // Поиск ученика по email
            $student->class_id = $request->class_id; // Установка идентификатора класса
            $student->save(); // Сохранение изменений

            return redirect()->route('showClassDetails', $request->class_id)->with('success', 'Ученик успешно добавлен.'); // Перенаправление на страницу деталей класса с сообщением об успехе
        }
    }
