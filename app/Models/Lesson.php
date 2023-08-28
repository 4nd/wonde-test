<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Lesson extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $dates = [
        'start_at',
        'end_at',
    ];

    public function scopeOnDay(Builder $builder, \DateTimeInterface $day)
    {
        return $builder->whereRaw('DATE(start_at) = "' . $day->format('Y-m-d') . '"');
    }

    public function scopeHasClassWithEmployee(Builder $builder, string $employeeId)
    {
        return $builder->whereHas(
            'schoolClass',
            function (Builder $builder) use ($employeeId) {
                $builder->withEmployee($employeeId);
            }
        );
    }

    public function scopeWithEmployeeId(Builder $builder, string $employeeId)
    {
        return $builder
            ->whereHas(
                'employee',
                function (Builder $builder) use ($employeeId) {
                    $builder->where('id', $employeeId);
                }
            );
    }

    public function scopeUniqueDays(Builder $builder)
    {
        return $builder
            ->selectRaw('DISTINCT(DATE(start_at)) AS day')
            ->orderBy('day', 'ASC');
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public static function fromStdClass(\stdClass $source): static
    {
        $lesson = new static();
        $lesson->id = $source->id;
        $lesson->start_at = Carbon::__set_state($source->start_at);
        $lesson->end_at = Carbon::__set_state($source->end_at);

        return $lesson;
    }
}
