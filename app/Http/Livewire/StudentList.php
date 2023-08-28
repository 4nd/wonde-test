<?php

namespace App\Http\Livewire;

use App\Models\Lesson;
use App\ViewModels\StudentList as StudentListView;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Livewire\Component;

class StudentList extends Component
{
    protected $students = null;

    protected $listeners = ['refreshStudents'];

    public function refreshStudents($employeeId, $selectedDate): void
    {
        if (!empty($employeeId) && !empty($selectedDate)) {
            $this->students = $this->getStudentsForEmployeeAndDay($employeeId, $selectedDate);
        }
    }

    public function mount()
    {
        $this->students = collect([]);
    }

    public function render()
    {
        return view('livewire.student-list', [
            'students' => $this->students ?: collect([])
        ]);
    }

    protected function getStudentsForEmployeeAndDay($employeeId, $selectedDate): Collection {
        $students = collect([]);

        if (empty($employeeId) || empty($selectedDate)) {
            return $students;
        }

        $selectedDate = new Carbon($selectedDate);

        // new object with student period, room, subject
        $lessons = Lesson::with(['schoolClass.students', 'room', 'period'])
            ->onDay($selectedDate)
            ->hasClassWithEmployee($employeeId)
            ->get();

        return $this->getStudentListViewModels($lessons);
    }

    public function getStudentListViewModels(EloquentCollection $lessons): Collection
    {
        $students = collect();
        foreach ($lessons as $lesson) {
            foreach ($lesson->schoolClass->students as $student) {
                if (!$students->has($student->id)) {
                    $students->put($student->id, new StudentListView($student, $lesson));
                }
            }
        }

        return $students->sortBy([
            fn (StudentListView $a, StudentListView $b) => $a->surname <=> $b->surname,
            fn (StudentListView $a, StudentListView $b) => $b->forename <=> $a->forename,
        ]);
    }
}
