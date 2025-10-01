<?php

use App\Models\Customer;
use App\Models\User;
use function Pest\Laravel\post;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {

});

it('can register', function () {
    post("/api/customer/register", [
        'phone' => '0912345678',
        'backup_phone' => '0937654321',
        'first_name' => 'John',
        'last_name' => 'Doeeee',
        'email' => 'johndoe@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ])->assertStatus(200);
});

it("can create an account", function () {
    post("/api/customer/register", [
        'phone' => '0912345678',
        'backup_phone' => '0937654321',
        'first_name' => 'John',
        'last_name' => 'Doeeee',
        'email' => 'johndoe@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $this->assertDatabaseCount('customers', 1);
});
