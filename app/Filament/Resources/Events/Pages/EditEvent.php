<?php

namespace App\Filament\Resources\Events\Pages;

use App\actions\EventActions\UpdateEventAction;
use App\Filament\Resources\Events\EventResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model ;
class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return (new UpdateEventAction(
            event: $record,
            name: $data['name'],
            description: $data['description'],
            location: $data['location'],
            start_date: $data['start_date'],
            end_date: $data['end_date'],
            company: $data['company_id'],
            city: $data['city_id'],
            ticketTypes: $data['ticketTypes'] ?? [],
        ))->execute();
    }
    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
