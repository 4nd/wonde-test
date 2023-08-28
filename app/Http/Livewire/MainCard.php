<?php

namespace App\Http\Livewire;

use App\Models\Employee;
use App\Models\Lesson;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class MainCard extends Component
{
    public $employees = [];

    public $dates = [];

    public $selectedDate = '';

    public $employeeId = null;

    public function mount(): void
    {
        $this->employees = Employee::all();
    }

    public function updatedSelectedDate(): void
    {
        $this->dates = $this->getUniqueDates($this->employeeId);
        $this->emit('refreshStudents', $this->employeeId, $this->selectedDate);
    }

    public function updatedEmployeeId(): void
    {
        $this->dates = $this->getUniqueDates($this->employeeId);
        $this->emit('refreshStudents', $this->employeeId, $this->selectedDate);
    }

    public function render(): Application|Factory|View
    {
        return view('livewire.main-card');
    }

    protected function getUniqueDates($employee): Collection
    {
        if (empty($employee)) {
            return collect();
        }

        return Lesson::withEmployeeId($employee)
            ->uniqueDays()
            ->pluck('day')
            ->map(fn($day) => new Carbon($day));
    }
}
