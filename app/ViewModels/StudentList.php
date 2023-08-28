<?php

namespace App\ViewModels;

use App\Models\Lesson;
use App\Models\Student;

class StudentList
{
    public $surname;
    public $forename;

    public function __construct(
        protected Student $student,
        protected Lesson  $lesson,
    )
    {
        $this->surname = $this->student->surname;
        $this->forename = $this->student->forename;
    }

    public function getClassName()
    {
        return $this->lesson->schoolClass->name;
    }

    public function getFirstSeenTime(): string
    {
        return substr($this->lesson->period->start_time, 0, 5);
    }

    public function getRoom(): string
    {
        return $this->lesson->room->name;
    }

    public function getName(): string
    {
        return implode(
            ', ',
            [
                $this->student->surname,
                $this->student->forename
            ]
        );
    }
}
