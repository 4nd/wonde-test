<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Wonde\Client;

class SchoolDataService implements SchoolDataServiceInterface
{
    const CACHE_TTL = 3600;

    protected Client $client;

    protected string $school;

    public function setClient(Client $client): SchoolDataService
    {
        $this->client = $client;
        return $this;
    }

    public function setSchool(string $school): SchoolDataService
    {
        $this->school = $school;
        return $this;
    }

    public function getEmployees(): Collection
    {
        return collect(
            Cache::remember('employees', self::CACHE_TTL, function () {
                return $this->client->school($this->school)->employees->all(
                    ['employment_details'],
                    [
                        'per_page' => 100,
                        'has_class' => true,
                        'has_role' => true,
                    ]
                );
            })
        );
    }


    public function getClassesWithStudentsAndSubjects(): \Iterator
    {
        return Cache::remember('classes', self::CACHE_TTL, function () {
            return $this->client->school($this->school)->classes->all(
                ['subject', 'students', 'employees'],
                [
                    'per_page' => 100,
                    'has_students' => true,
                ]
            );
        });
    }

    public function getLessonsWithClassPeriodRoomAndEmployee(): \Iterator
    {
        return Cache::remember('lessons', self::CACHE_TTL, function () {
            return $this->client->school($this->school)->lessons->all(
                ['class', 'period', 'room', 'employee'],
                [
                    'per_page' => 100,
                    'lessons_start_after' => '2023-07-01',
                ]
            );
        });
    }
}
