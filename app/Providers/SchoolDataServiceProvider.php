<?php

namespace App\Providers;

use App\Mappers\ClassMapper;
use App\Mappers\EmployeeMapper;
use App\Mappers\LessonMapper;
use App\Mappers\PeriodMapper;
use App\Mappers\RoomMapper;
use App\Mappers\StudentMapper;
use App\Mappers\SubjectMapper;
use App\Services\SchoolDataService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Wonde\Client;

class SchoolDataServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('school.data.service', function (Application $app) {
            return (new SchoolDataService())
                ->setClient(new Client(config('wonde.token')))
                ->setSchool(config('wonde.school'));
        });
    }

    public function boot(): void
    {
        //
    }
}
