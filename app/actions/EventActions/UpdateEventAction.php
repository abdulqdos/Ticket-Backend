<?php

namespace App\actions\EventActions ;
use App\Models\Event;
use Illuminate\Support\Facades\DB;


Class UpdateEventAction
{

    public function __construct(
        public Event $event,
        public string $name,
        public string $description,
        public string $location,
        public string $start_date,
        public string $end_date,
        public int $company,
        public int $city,
        public array $ticketTypes
    ) {}

    public function execute(): Event
    {
        return DB::transaction(function () {
             $this->event->update([
                 "name" => $this->name,
                 "description" => $this->description,
                 "start_date" => $this->start_date,
                 "end_date" => $this->end_date,
                 "location" => $this->location,
                 "company_id" => $this->company,
                 "city_id" => $this->city
            ]);

             $this->event->ticketTypes()->delete();

            foreach($this->ticketTypes as $type)
            {
                (new CreateEventTicketTypeAction(
                    name: $type['name'],
                    price: $type['price'],
                    quantity: $type['quantity'],
                    event: $this->event,
                ))->execute();
            }

            return $this->event->fresh();
        });
    }
}
