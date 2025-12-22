<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\CustomerFactory;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Make a Role
        Role::create(['name' => 'admin' , 'guard_name' => 'web']);

        // Create Admin
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
        ]);

        $admin->assignRole('admin');

        // Create Event
        $event = Event::factory()->create();

        TicketType::factory(2)->recycle($event)->create();

        Customer::factory(10)->create();

        Customer::factory()->create([
            'phone' => "0916050468",
        ]);

        Ticket::factory()->create([
           'customer_id' => 11,
           'ticket_type_id' => 2,
        ]);
    }
}
