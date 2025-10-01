<?php

use App\Models\Customer;
use App\Models\User;
use function Pest\Laravel\post;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->user = Customer::factory()->create([
        'phone' => '0916050469',
        'password' => Hash::make('password123'),
    ]);
});

it('Login with correct credentials returns 200', function () {
    post('/api/customer/login', [
        'phone' => $this->user->phone,
        'password' => "password123",
    ])->assertStatus(200);
});

it('Login with wrong credentials returns 401', function () {
    post('/api/customer/login', [
        'phone' => $this->user->phone,
        'password' => 'wrongpassword',
    ])->assertStatus(401);
});


