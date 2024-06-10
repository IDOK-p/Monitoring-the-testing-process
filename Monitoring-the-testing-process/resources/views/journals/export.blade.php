<table>
    <thead>
        <tr>
            <th>Ученик</th>
            @foreach($tests as $test)
                <th>{{ $test->name }}</th>
            @endforeach
            <th>Средний балл за период</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
            <tr>
                <td>{{ $student->surname }} {{ $student->name }} {{ $student->patronymic }}</td>
                @foreach($tests as $test)
                    <td>
                        @foreach($grades as $grade)
                            @if($grade->student_id == $student->id && $grade->test_id == $test->id)
                                {{ $grade->grade }}
                            @endif
                        @endforeach
                    </td>
                @endforeach
                <td>{{ $studentAverages[$student->id] }}</td>
            </tr>
        @endforeach
        <tr>
            <td>Средний балл за тест</td>
            @foreach($tests as $test)
                <td>{{ $testAverages[$test->id] }}</td>
            @endforeach
        </tr>
    </tbody>
</table>
