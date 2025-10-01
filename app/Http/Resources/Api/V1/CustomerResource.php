<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
                "id" => $this->id,
                "type" => "customer",
                "attributes" => [
                    'phone' => $this->phone,
                    'backup_phone' => $this->backup_phone,
                    'first_name'   => $this->first_name,
                    'last_name'    => $this->last_name,
                    'email'        => $this->email,
                ],
                'relationships' => [
                    'tickets' => [
                        "data" => $this->ticketTypes->map(function($type) {
                            return [
                                "id"   => $type->id,
                                "type" => "tickets",
                            ];
                        })
                    ],
                ],
                'includes' => [
                    'tickets' => [
                        "data" => TicketTypeResource::collection($this->whenLoaded('ticketTypes')),
                    ],
                ],
                'links' => [
                    'self' => route('api.v1.customers.show' , ['customer' => $this->id])
                ]
        ];
    }
}
