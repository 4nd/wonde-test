<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(SchoolClass::class);
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public static function fromStdClass(\stdClass $source): static
    {
        $employee = new static();
        $employee->id = $source->id;
        $employee->forename = $source->forename;
        $employee->surname = $source->surname;
        $employee->title = $source->title;
        $employee->initials = $source->initials;

        return $employee;
    }
}
