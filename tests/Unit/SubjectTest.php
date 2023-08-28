<?php
test('can create from stdClass', function () {
    $data = new stdClass();
    $data->id = fake()->uuid;
    $data->name = fake()->sentence;
    $data->code = fake()->randomAscii();
    $data->active = fake()->boolean();

    $subject = \App\Models\Subject::fromStdClass($data);

    expect($subject->id)->toBe($data->id)
        ->and($subject->name)->toBe($data->name)
        ->and($subject->code)->toBe($data->code)
        ->and($subject->active)->toBeBool();
});
