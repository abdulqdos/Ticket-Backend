<?php

use App\actions\EventActions\CreateEventAction;
use App\actions\EventActions\CreatEventAction;
use App\Filament\Resources\Events\Pages\CreateEvent;
use App\Models\City;
use App\Models\Event;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;

beforeEach(function () {
    $this->company = Company::factory()->create([
        "phone" => "0916050468",
        "name" => "Sahab"
    ]);

    $this->city = City::factory()->create([
        "name" => "Tripoli"
    ]);

    $this->ticketTypes = [
        [
            'name' => 'VIP',
            'price' => 100,
            'quantity' => 10,
        ],
        [
            'name' => 'Regular',
            'price' => 50,
            'quantity' => 20,
        ],
    ];

});

it('create an event with ticket types', closure: function () {
    $action = new CreateEventAction(
        name: 'Test Event',
        description: 'This is a test event',
        location: 'Tripoli',
        start_date: now()->addDays(1),
        end_date: now()->addDays(2),
        company: $this->company->id,
        city: $this->city->id,
        ticketTypes: $this->ticketTypes
    );

    $event = $action->execute();


    expect(Event::count())->toBe(1);
    expect($event->name)->toBe('Test Event');
    expect($event->location)->toBe('Tripoli');

    expect($event->ticketTypes)->toHaveCount(2);
    expect($event->ticketTypes()->first()->name)->toBe('VIP');
});

it('has correct name', function ($badName) {
    Livewire::test(CreateEvent::class)
        ->fillForm([
        'name'        => $badName,
        'description' => 'This is a description for the event',
        'start_date'  => now()->addDays(1),
        'end_date'    => now()->addDays(2),
        'city_id'     => $this->city->id,
        'ticketTypes' => [
            [
                'name'  => 'VIP',
                'price' => 100,
            ],
            [
                'name'  => 'Regular',
                'price' => 50,
            ]
        ],
    ], "form")->call("create")->assertHasFormErrors(["name"]);
})->with([
    " ",
    "abd",
    str_repeat("a" , 256),
    123,
    1.5,
    "<script></script>",
    null
]);

