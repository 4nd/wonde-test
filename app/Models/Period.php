<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Period extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public static function fromStdClass(\stdClass $source): static
    {
        $period = new static();
        $period->id = $source->id;
        $period->start_time = $source->start_time;
        $period->end_time = $source->end_time;
        $period->day = $source->day;

        return $period;
    }
}
