<?php

namespace App\Services;

use Illuminate\Support\Collection;

interface SchoolDataServiceInterface
{
    public function getEmployees(): Collection;

    public function getClassesWithStudentsAndSubjects(): \Iterator;

    public function getLessonsWithClassPeriodRoomAndEmployee(): \Iterator;
}
