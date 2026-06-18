<?php

use App\Models\Payment;
use App\Models\User;

it('sorts payment records by student name from A to Z', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $zoe = Payment::create([
        'student_name' => 'Zoe Recto',
        'course' => 'DHRT',
        'year_level' => '2nd Year',
        'amount' => 200,
        'date' => now()->toDateString(),
        'description' => 'Test Fee',
        'recorded_by' => $user->name,
    ]);
    $anna = Payment::create([
        'student_name' => 'Anna Mayor',
        'course' => 'DHRT',
        'year_level' => '2nd Year',
        'amount' => 250,
        'date' => now()->toDateString(),
        'description' => 'Test Fee',
        'recorded_by' => $user->name,
    ]);

    $response = $this->actingAs($user)->get(route('payments.index'));

    $response->assertOk();

    $names = $response->viewData('payments')->getCollection()->pluck('student_name')->all();

    expect($names)->toEqual([$anna->student_name, $zoe->student_name]);
});
