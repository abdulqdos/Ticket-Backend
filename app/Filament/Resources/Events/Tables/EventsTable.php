<?php

namespace App\Filament\Resources\Events\Tables;

use App\actions\EventActions\UpdateEventAction;
use App\Models\Event;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(),
                TextColumn::make('description')
                    ->label(__('Description'))
                    ->searchable(),
                TextColumn::make('location')
                    ->label(__('Location'))
                    ->numeric(),
                TextColumn::make('start_date')
                    ->label(__('Start Date'))
                    ->dateTime('M d, Y')
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label(__('End Date'))
                    ->dateTime('M d, Y')
                    ->sortable(),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label(__('created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('company.name')
                    ->label(__('Company'))
                    ->sortable(),

                TextColumn::make('city.name')
                    ->label(__('City'))
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make()->color("warning"),
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
                    ))->execute()
                )),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
