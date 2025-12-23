<?php

namespace App\actions\TicketActions ;

use App\Models\Ticket;
use App\Models\TicketType;
use Illuminate\Support\Facades\DB;

class CreateTicketAction
{

    protected Ticket $ticket ;
    public function __construct(
        public int $ticketType_id,
        public int $customer_id,
        public TicketType $ticket_type
    ) {}

    public function execute(): Ticket
    {
        return DB::transaction(function () {
            $this->ticket_type->decrement('quantity');

            $this->ticket = Ticket::create([
                "ticket_type_id" => $this->ticketType_id,
                'customer_id' => $this->customer_id
            ]);

            return $this->ticket;
        });
    }
}
