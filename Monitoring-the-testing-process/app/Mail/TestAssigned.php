<?php

    namespace App\Mail;

    use App\Models\Test;
    use App\Models\Student;
    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;

    class TestAssigned extends Mailable
    {
        use Queueable, SerializesModels;

        public $test;
        public $student;

        public function __construct(Test $test, Student $student)
        {
            $this->test = $test;
            $this->student = $student;
        }

        public function build()
        {
            return $this->markdown('emails.test_assigned')
                        ->subject('Назначен тест')
                        ->with([
                            'testName' => $this->test->name,
                            'studentName' => $this->student->name,
                        ]);
        }
    }
