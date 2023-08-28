<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SchoolClass extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    public function scopeWithEmployee(Builder $builder, $employeeId)
    {
        return
            $builder->whereHas(
                'employees',
                function(Builder $builder) use ($employeeId) {
                    $builder->where('employee_id', $employeeId);
                }
            );
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public static function fromStdClass(\stdClass $source): static
    {
        $class = new static();
        $class->id = $source->id;
        $class->name = $source->name;
        $class->description = $source->description;

        return $class;
    }
}
