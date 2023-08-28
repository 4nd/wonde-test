<?php

namespace App\Synchronisers;

use App\Models\Employee;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Services\SchoolDataServiceInterface;
use Illuminate\Console\OutputStyle;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SynchroniseClassesAndStudents
{
    protected int $count = 0;

    public function __construct(
        protected SchoolDataServiceInterface $schoolDataService,
        protected OutputStyle                $output,
    ) { }

    public function __invoke()
    {
        SchoolClass::truncate();
        Student::truncate();
        Subject::truncate();
        DB::table('school_class_student')->truncate();
        DB::table('employee_school_class')->truncate();

        $classesData = $this->schoolDataService->getClassesWithStudentsAndSubjects();
        $classes = collect();
        foreach ($classesData as $classData) {
            $class = SchoolClass::fromStdClass($classData);
            $class->save();

            if (!empty($classData->students?->data)) {
                $students = $this->mapStudents(collect($classData->students->data));
                $class->students()->attach($students->pluck('id'));
                $class->save();
            }

            if (!empty($classData->employees?->data)) {
                $employees = $this->mapEmployees(collect($classData->employees->data));
                $class->employees()->attach($employees->pluck('id'));
            }

            if (!empty($classData->subject?->data)) {
                $subject = $this->mapSubject($classData->subject->data);
                $class->subject()->associate($subject);
            }

            $class->save();
            $this->count++;
            if ($this->count % 10 == 0) {
                $this->output->write('.');
            }
            $classes->push($class);
        }

        $this->output->writeln($this->count . '');

        return $classes;
    }

    protected function mapStudents(Collection $studentsData): Collection
    {
        return $studentsData->map(function ($studentData) {
            $student = Student::findOr(
                $studentData->id,
                function () use ($studentData) {
                    $student = Student::fromStdClass($studentData);
                    $student->save();

                    return $student;
                }
            );

            return $student;
        });
    }

    protected function mapSubject($subjectData): Subject
    {
        return Subject::findOr($subjectData->id,
            function () use ($subjectData) {
                $subject = Subject::fromStdClass($subjectData);
                $subject->save();

                return $subject;
            }
        );
    }

    protected function mapEmployees(Collection $employeesData): Collection
    {
        return $employeesData->map(function ($employeeData) {
            return Employee::findOr($employeeData->id, fn() => null);
        });
    }
}
