<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    public static function fromStdClass(\stdClass $source): static
    {
        $room = new static();
        $room->id = $source->id;
        $room->code = $source->code;
        $room->name = $source->name;

        return $room;
    }
}
