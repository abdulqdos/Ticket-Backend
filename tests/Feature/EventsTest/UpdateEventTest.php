<?php


use App\actions\EventActions\CreateEventAction;
use App\actions\EventActions\CreatEventAction;
use App\actions\EventActions\UpdateEventAction;
use App\Filament\Resources\Events\Pages\EditEvent;
use App\Models\City;
use App\Models\Company;
use App\Models\Event;
use App\Models\TicketType;

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
        ]
    ];

    $this->newTicketTypes = [
        [
            'name' => 'NewTicket',
            'price' => 100,
            'quantity' => 10,
        ],
        [
            'name' => 'Regular',
            'price' => 50,
            'quantity' => 20,
        ],
    ];

    $this->data = Event::factory()->create([
        "name" => 'Test Event',
        "description" => 'This is a test event',
        "location" => 'Tripoli',
        "start_date" => now()->addDays(1),
        "end_date" => now()->addDays(2),
        "company_id" => $this->company->id,
        "city_id" => $this->city->id,
    ]);

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

    $this->event = $action->execute();

});

it('update an event with ticket types', closure: function () {
    $action = new UpdateEventAction(
        event: $this->event,
        name: 'New Test Event',
        description: 'New This is a test event',
        location: 'Bengazi',
        start_date: now()->addDays(1),
        end_date: now()->addDays(2),
        company: $this->company->id,
        city: $this->city->id,
        ticketTypes: $this->newTicketTypes
    );

    $newEvent = $action->execute();

    expect($newEvent->name)->toBe('New Test Event');
    expect($newEvent->location)->toBe('Bengazi');
    expect($newEvent->ticketTypes()->first()->name)->toBe('NewTicket');

    expect($newEvent->name)->not->toBe("Test Event");
    expect($newEvent->location)->not->toBe("Tripoli");
});



it('Has a correct name', closure: function ($badName) {

//    dd($this->event);
    Livewire::test(EditEvent::class , [
        'record' => $this->event->getKey()
    ])
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
        ], "form")->call("save")->assertHasFormErrors(["name"]);
})->with([
    " ",
    "abd",
    str_repeat("a" , 256),
    123,
    1.5,
    "<script></script>",
    null
]);;
