<?php

namespace App\Synchronisers;

use App\Models\Employee;
use App\Models\Lesson;
use App\Models\Period;
use App\Models\Room;
use App\Models\SchoolClass;
use App\Services\SchoolDataServiceInterface;
use Illuminate\Console\OutputStyle;

class SynchroniseLessonsWithClassPeriodRoomAndEmployee
{
    protected $count = 0;

    public function __construct(
        protected SchoolDataServiceInterface $schoolDataService,
        protected OutputStyle                $output,
    ) { }

    public function __invoke()
    {
        Lesson::truncate();
        Period::truncate();
        Room::truncate();

        $lessonsData = $this->schoolDataService->getLessonsWithClassPeriodRoomAndEmployee();
        $lessons = collect();
        foreach ($lessonsData as $lessonData) {
            $lesson = Lesson::fromStdClass($lessonData);

            if (!empty($lessonData->class?->data)) {
                if ($class = SchoolClass::findOr($lessonData->class->data->id, fn() => null)) {
                    $lesson->schoolClass()->associate($class);
                }
            }

            if (!empty($lessonData->employee?->data)) {
                if ($class = Employee::findOr($lessonData->employee->data->id, fn() => null)) {
                    $lesson->employee()->associate($class);
                }
            }

            if (!empty($lessonData->period?->data)) {
                $period = $this->mapPeriod($lessonData->period->data);
                $lesson->period()->associate($period);
            }

            if (!empty($lessonData->room?->data)) {
                $room = $this->mapRoom($lessonData->room->data);
                $lesson->room()->associate($room);
            }
            $lesson->save();

            $this->count++;
            if ($this->count % 10 == 0) {
                $this->output->write('.');
            }

            $lessons->push($lesson);
        }

        $this->output->writeln($this->count . '');

        return $lessons;
    }

    protected function mapPeriod($periodData): Period
    {
        return Period::findOr($periodData->id,
            function () use ($periodData) {
                $period = Period::fromStdClass($periodData);
                $period->save();

                return $period;
            }
        );
    }

    protected function mapRoom($roomData): Room
    {
        return Room::findOr($roomData->id,
            function () use ($roomData) {
                $room = Room::fromStdClass($roomData);
                $room->save();

                return $room;
            }
        );
    }
}
