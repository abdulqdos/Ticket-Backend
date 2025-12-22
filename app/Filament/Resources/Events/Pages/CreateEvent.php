<?php

namespace App\Filament\Resources\Events\Pages;

use App\actions\EventActions\CreateEventAction;
use App\Filament\Resources\Events\EventResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;

    protected function handleRecordCreation(array $data): \App\Models\Event
    {
        return ((new CreateEventAction(
            name: $data['name'],
            description: $data['description'],
            location: $data['location'],
            start_date: $data['start_date'],
            end_date: $data['end_date'],
            company: $data['company_id'],
            city: $data['city_id'],
            ticketTypes: $data['ticketTypes'] ?? [],
        ))->execute());
    }

    public function getHeading(): string|Htmlable
    {
        return __("Create Event");
    }
}
