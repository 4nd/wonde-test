<?php

namespace App\Synchronisers;

use App\Models\Employee;
use App\Services\SchoolDataServiceInterface;
use Illuminate\Console\OutputStyle;

class SynchroniseEmployees
{
    protected int $count = 0;

    public function __construct(
        protected SchoolDataServiceInterface $schoolDataService,
        protected OutputStyle                $output,
    ) { }

    public function __invoke()
    {
        Employee::truncate();
        $employeeData = $this->schoolDataService->getEmployees();

        $employees = $employeeData->map(function ($sourceEmployee) {
            if ($this->count % 10 == 0) {
                $this->output->write('.');
            }

            if ($sourceEmployee->employment_details?->data?->current) {
                $employee = Employee::fromStdClass($sourceEmployee);
                $employee->save();
                $this->count++;

                return $employee;
            }

            return null;
        });

        $this->output->writeln($this->count . '');

        return $employees;
    }
}
