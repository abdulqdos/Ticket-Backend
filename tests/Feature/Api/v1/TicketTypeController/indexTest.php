<?php



use App\Http\Resources\Api\V1\TicketTypeResource;
use App\Models\TicketType;
use function Pest\Laravel\get;
use function Pest\Laravel\getJson;

beforeEach(function () {
    $this->ticketTypes = TicketTypeResource::collection(TicketType::all())
        ->response()
        ->getData(true)['data'];
});

it('can access the route', function () {
    getJson(route('api.v1.ticket-types.index'))
        ->assertStatus(200);
});

it('has all ticketTypes', function () {
    $this->getJson(route('api.v1.ticket-types.index'))
        ->assertJson([
            'data' =>  $this->ticketTypes ,
        ]);
});
