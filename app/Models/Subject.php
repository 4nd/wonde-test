<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['id'];

    public function classes(): HasMany
    {
        return $this->hasMany(SchoolClass::class);
    }

    public static function fromStdClass(\stdClass $source): static
    {
        $subject = new static();
        $subject->id = $source->id;
        $subject->name = $source->name;
        $subject->code = $source->code;
        $subject->active = $source->active;

        return $subject;
    }
}
