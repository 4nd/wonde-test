<?php
test('can create from stdClass', function () {
    $data = new stdClass();
    $data->id = fake()->uuid;
    $data->forename = fake()->firstName();
    $data->surname = fake()->lastName();
    $data->title = fake()->title();
    $data->initials = fake()->randomLetter();

    $employee = \App\Models\Employee::fromStdClass($data);

    expect($employee->id)->toBe($data->id)
        ->and($employee->forename)->toBe($data->forename)
        ->and($employee->surname)->toBe($data->surname)
        ->and($employee->title)->toBe($employee->title)
        ->and($employee->initials)->toBe($employee->initials);
});
