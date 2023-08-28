<?php

namespace App\Console\Commands;

use App\Synchronisers\SynchroniseClassesAndStudents;
use App\Synchronisers\SynchroniseEmployees;
use App\Synchronisers\SynchroniseLessonsWithClassPeriodRoomAndEmployee;
use Illuminate\Console\Command;

class AppSync extends Command
{
    /** @var string */
    protected $signature = 'app:sync';

    /** @var string */
    protected $description = 'Synchronise data from Wonde to Local DB so we can run the UI without hammering the API';

    public function handle(): int
    {
        $dataService = app('school.data.service');

        $this->info('Synchronising Employees ');
        (new SynchroniseEmployees($dataService, $this->output))();

        $this->info('Synchronising Classes w/Students & Subjects ');
        (new SynchroniseClassesAndStudents($dataService, $this->output))();

        $this->info('Synchronising Lessons, Periods and Rooms ');
        (new SynchroniseLessonsWithClassPeriodRoomAndEmployee($dataService, $this->output))();

        return Command::SUCCESS;
    }
}
