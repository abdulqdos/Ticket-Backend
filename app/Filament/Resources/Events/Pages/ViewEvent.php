<?php

namespace App\Filament\Resources\Events\Pages;

use App\actions\EventActions\UpdateEventAction;
use App\Filament\Resources\Events\EventResource;
use App\Models\Event;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewEvent extends ViewRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->hidden(fn ($record): bool => $record->start_date <= now())
                ->using(fn ($record, array $data): Event => (
                (new UpdateEventAction(
                    event: $record,
                    name: $data['name'],
                    description: $data['description'],
                    location: $data['location'],
                    start_date: $data['start_date'],
                    end_date: $data['end_date'],
                    company: $data['company_id'],
                    city: $data['city_id'],
                    ticketTypes: $data['ticketTypes'],
                ))->execute())),
        ];
    }

    public function getHeading(): string|Htmlable
    {
        return __("View Event");
    }
}
