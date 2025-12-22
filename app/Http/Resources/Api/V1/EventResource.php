<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type'  => 'event',
            'attributes' => [
                "name" => $this->name,
                "description" => $this->description,
                "start_date" => $this->start_date,
                "end_date" => $this->end_date,
                "location" => $this->location,
            ],
            'relationships' => [
                'ticket_types' => [
                    'data' => $this->ticketTypes->map(function ($ticketType) {
                        return [
                            'type' => 'ticket_types',
                            'id'   => $ticketType['id'],
                        ];
                    }),
                ],

                'city' => [
                    'data' => [
                        'type' => 'city',
                        'id' => $this->city_id
                    ]
                ],

                'company' => [
                    'data' => [
                        'type' => 'company',
                        'id' => $this->company_id
                    ]
                ],
                'images' => [
                    'data' => $this->getMedia('images')->map(fn ($media) => [
                        'id'   => (string) $media->id,
                        'type' => 'media',
                    ]),
                ],
            ],
            'includes' => [
                'city' => new CityResource($this->city),
                'company' => new CompanyResource($this->company),
                'ticketTypes' => TicketTypeResource::collection($this->whenLoaded('ticketTypes')),
            ],
            'links' => [
                'self' => route('api.v1.events.show' , ['event' => $this->id])
            ],
        ];
    }
}
