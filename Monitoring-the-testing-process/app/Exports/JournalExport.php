<?php

namespace App\Exports;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Test;
use App\Models\ClassModel;
use App\Models\Subject;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class JournalExport implements FromView
{
    protected $classId;
    protected $subjectId;
    protected $dateFrom;
    protected $dateTo;

    public function __construct($classId, $subjectId, $dateFrom, $dateTo)
    {
        $this->classId = $classId;
        $this->subjectId = $subjectId;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function view(): View
    {
        $students = Student::where('class_id', $this->classId)->get();
        $tests = Test::where('subject_id', $this->subjectId)
            ->when($this->dateFrom, function ($query) {
                return $query->where('date', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                return $query->where('date', '<=', $this->dateTo);
            })
            ->get();

        $grades = Grade::whereIn('student_id', $students->pluck('id'))
            ->whereIn('test_id', $tests->pluck('id'))
            ->get();

        $studentAverages = [];
        foreach ($students as $student) {
            $studentGrades = $grades->where('student_id', $student->id);
            $totalGrades = $studentGrades->sum('grade');
            $gradeCount = $studentGrades->count();
            $studentAverages[$student->id] = $gradeCount > 0 ? round($totalGrades / $gradeCount, 1) : 0;
        }

        $testAverages = [];
        foreach ($tests as $test) {
            $testGrades = $grades->where('test_id', $test->id);
            $totalGrades = $testGrades->sum('grade');
            $gradeCount = $testGrades->count();
            $testAverages[$test->id] = $gradeCount > 0 ? round($totalGrades / $gradeCount, 1) : 0;
        }

        return view('journals.export', [
            'students' => $students,
            'tests' => $tests,
            'grades' => $grades,
            'studentAverages' => $studentAverages,
            'testAverages' => $testAverages,
        ]);
    }
}

