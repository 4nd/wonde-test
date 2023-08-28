<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(SchoolClass::class);
    }

    public static function fromStdClass(\stdClass $source): static
    {
        $student = new static();
        $student->id = $source->id;
        $student->forename = $source->forename;
        $student->surname = $source->surname;
        $student->initials = $source->initials;
        $student->middle_names = $source->middle_names;

        return $student;
    }
}
