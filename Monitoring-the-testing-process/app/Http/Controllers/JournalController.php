<?php

    namespace App\Http\Controllers;

    use App\Models\Student;
    use App\Models\Teacher;
    use App\Models\Test;
    use App\Models\Grade;
    use App\Models\ClassModel;
    use App\Models\Subject;
    use Illuminate\Http\Request;
    use App\Exports\JournalExport;
    use Maatwebsite\Excel\Facades\Excel;

    class JournalController extends Controller
    {
        // Метод для отображения страницы журнала
        public function showJournal()
        {
            $userId = session('id');
            $user = Teacher::find($userId);
            $errorMessage = '';
            if (empty($user->city_id) || empty($user->school_id)) {
                $errorMessage = 'Пожалуйста, выберите город и школу перед использованием этой страницы.';
                return view('journals/journal', ['user' => $userId], compact('errorMessage'));
            } else {
                $students = [];
                $tests = [];
                $grades = Grade::all();
                $classes = ClassModel::all();
                $subjects = Subject::all();

                // Возвращаем представление журнала, передавая необходимые данные
                return view('journals/journal', ['user' => $userId], compact('students', 'tests', 'grades', 'classes', 'subjects'));
            }
        }

        // Метод для фильтрации журнала по классу, предмету и датам
        public function filterJournal(Request $request)
        {
            $userId = session('id');
            $classId = $request->input('class_id');
            $subjectId = $request->input('subject_id');
            $dateFrom = $request->input('date_from');
            $dateTo = $request->input('date_to');

            $students = [];
            $tests = [];
            $grades = Grade::all();
            $classes = ClassModel::all();
            $subjects = Subject::all();

            $selectedClass = null;
            $selectedSubject = null;

            // Если выбран класс и предмет, получаем соответствующих студентов и тесты
            if ($classId && $subjectId) {
                $students = Student::where('class_id', $classId)->get();
                $tests = Test::where('subject_id', $subjectId)
                    ->when($dateFrom, function ($query, $dateFrom) {
                        return $query->where('date', '>=', $dateFrom);
                    })
                    ->when($dateTo, function ($query, $dateTo) {
                        return $query->where('date', '<=', $dateTo);
                    })
                    ->get();

                $selectedClass = ClassModel::find($classId);
                $selectedSubject = Subject::find($subjectId);

                // Получаем оценки только для выбранных студентов и тестов
                $grades = Grade::whereIn('student_id', $students->pluck('id'))
                            ->whereIn('test_id', $tests->pluck('id'))
                            ->get();
            }

            // Вычисляем средние оценки для каждого студента
            $studentAverages = [];
            foreach ($students as $student) {
                $studentGrades = $grades->where('student_id', $student->id);
                $totalGrades = $studentGrades->sum('grade');
                $gradeCount = $studentGrades->count();
                $studentAverages[$student->id] = $gradeCount > 0 ? round($totalGrades / $gradeCount, 1) : 0;
            }

            // Вычисляем средние оценки для каждого теста
            $testAverages = [];
            foreach ($tests as $test) {
                $testGrades = $grades->where('test_id', $test->id);
                $totalGrades = $testGrades->sum('grade');
                $gradeCount = $testGrades->count();
                $testAverages[$test->id] = $gradeCount > 0 ? round($totalGrades / $gradeCount, 1) : 0;
            }

            // Возвращаем представление журнала, передавая отфильтрованные данные и средние оценки
            return view('journals/journal', ['user' => $userId], compact('students', 'tests', 'grades', 'classes', 'subjects', 'selectedClass', 'selectedSubject', 'studentAverages', 'testAverages'));
        }

        // Метод для отображения деталей ученика
        public function showStudentDetails($studentId, Request $request)
        {
            $userId = session('id');
            $student = Student::find($studentId);
            $classId = $student->class_id;
            $subjectId = $request->input('subject_id');
            $dateFrom = $request->input('date_from');
            $dateTo = $request->input('date_to');
            $testAverages = $request->input('testAverages');

            // Получаем оценки ученика в выбранный период по выбранному предмету
            $grades = Grade::where('student_id', $studentId)
                ->whereHas('test', function ($query) use ($subjectId, $dateFrom, $dateTo) {
                    if ($subjectId) {
                        $query->where('subject_id', $subjectId);
                    }
                    if ($dateFrom) {
                        $query->where('date', '>=', $dateFrom);
                    }
                    if ($dateTo) {
                        $query->where('date', '<=', $dateTo);
                    }
                })
                ->get();

            $testIds = $grades->pluck('test_id')->unique()->toArray(); // Получаем уникальные ID тестов

            // Получаем тесты, в которых ученик получил оценки
            $tests = Test::whereIn('id', $testIds)
                ->when($subjectId, function ($query, $subjectId) {
                    return $query->where('subject_id', $subjectId);
                })
                ->when($dateFrom, function ($query, $dateFrom) {
                    return $query->where('date', '>=', $dateFrom);
                })
                ->when($dateTo, function ($query, $dateTo) {
                    return $query->where('date', '<=', $dateTo);
                })
                ->get();

            $studentGrades = [];

            // Получаем оценки ученика по каждому тесту
            foreach ($tests as $test) {
                $studentGrade = $grades->where('test_id', $test->id)->first();
                $studentGrades[] = $studentGrade ? $studentGrade->grade : null;
            }

            $testAveragesNew = [];
            foreach ($tests as $test) {
                $testAveragesNew[] = isset($testAverages[$test->id]) ? $testAverages[$test->id] : null;
            }

            // Отображаем представление с деталями ученика
            return view('journals/student_details', ['user' => $userId], compact('student', 'studentGrades', 'testAveragesNew', 'tests'));
        }

        // Метод для отображения статистики по тесту
        public function showTestStatistics(Request $request, $testId)
        {
            $userId = session('id');
            $test = Test::findOrFail($testId);

            $classId = $request->input('class_id');
            $subjectId = $request->input('subject_id');

            // Проверяем, что class_id и subject_id переданы
            if (!$classId || !$subjectId) {
                // Обработка ошибки, если class_id или subject_id не переданы
                return redirect()->back()->withErrors(['error' => 'Класс и предмет обязательны для фильтрации статистики']);
            }

            // Подсчитываем количество оценок для каждой оценки (2, 3, 4, 5), учитывая класс и предмет
            $gradeCounts = [
                '5' => Grade::where('test_id', $testId)
                            ->where('grade', 5)
                            ->whereHas('student', function ($query) use ($classId) {
                                $query->where('class_id', $classId);
                            })
                            ->count(),
                '4' => Grade::where('test_id', $testId)
                            ->where('grade', 4)
                            ->whereHas('student', function ($query) use ($classId) {
                                $query->where('class_id', $classId);
                            })
                            ->count(),
                '3' => Grade::where('test_id', $testId)
                            ->where('grade', 3)
                            ->whereHas('student', function ($query) use ($classId) {
                                $query->where('class_id', $classId);
                            })
                            ->count(),
                '2' => Grade::where('test_id', $testId)
                            ->where('grade', 2)
                            ->whereHas('student', function ($query) use ($classId) {
                                $query->where('class_id', $classId);
                            })
                            ->count(),
            ];

            // Получаем списки учеников для каждой оценки
            $studentsByGrade = [
                '5' => Grade::where('test_id', $testId)
                            ->where('grade', 5)
                            ->whereHas('student', function ($query) use ($classId) {
                                $query->where('class_id', $classId);
                            })
                            ->with('student')
                            ->get()
                            ->pluck('student'),
                '4' => Grade::where('test_id', $testId)
                            ->where('grade', 4)
                            ->whereHas('student', function ($query) use ($classId) {
                                $query->where('class_id', $classId);
                            })
                            ->with('student')
                            ->get()
                            ->pluck('student'),
                '3' => Grade::where('test_id', $testId)
                            ->where('grade', 3)
                            ->whereHas('student', function ($query) use ($classId) {
                                $query->where('class_id', $classId);
                            })
                            ->with('student')
                            ->get()
                            ->pluck('student'),
                '2' => Grade::where('test_id', $testId)
                            ->where('grade', 2)
                            ->whereHas('student', function ($query) use ($classId) {
                                $query->where('class_id', $classId);
                            })
                            ->with('student')
                            ->get()
                            ->pluck('student'),
            ];

            // Передаем данные в представление и отображаем страницу статистики по тестам
            return view('journals.statistics', ['user' => $userId], compact('test', 'gradeCounts', 'classId', 'subjectId', 'studentsByGrade'));
        }

        // Метод для экспорта данных журнала в файл Excel
        public function export(Request $request)
        {
            $classId = $request->input('class_id');
            $subjectId = $request->input('subject_id');
            $dateFrom = $request->input('date_from');
            $dateTo = $request->input('date_to');

            // Экспортируем данные журнала в файл Excel с использованием класса JournalExport
            return Excel::download(new JournalExport($classId, $subjectId, $dateFrom, $dateTo), 'journal.xlsx');
        }

    }
