<?php

namespace App\Filament\Resources\Events\Schemas;

use App\Models\TicketType;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
class EventInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make(__('Main Information'))
                    ->columnSpanFull()
                    ->schema([
                        SpatieMediaLibraryImageEntry::make('images')
                            ->label(__('Event Images'))
                            ->collection("event-images"),

                        Group::make()
                            ->columnSpan(2)
                            ->columns(2)
                            ->schema([
                                TextEntry::make('name')
                                    ->label(__('Name'))
                                    ->weight('bold')
                                    ->size('lg'),

                                TextEntry::make('company.name')
                                    ->label(__('Company'))
                                    ->icon('heroicon-o-building-office'),

                                TextEntry::make('description')
                                    ->label(__('Description'))
                                    ->columnSpanFull()
                                    ->placeholder('-'),

                                TextEntry::make('start_date')
                                    ->label(__('Start Date'))
                                    ->dateTime('d M Y - h:i A')
                                    ->icon('heroicon-o-calendar'),

                                TextEntry::make('end_date')
                                    ->label(__('End Date'))
                                    ->dateTime('d M Y - h:i A')
                                    ->icon('heroicon-o-calendar'),

                                TextEntry::make('location')
                                    ->label(__('Location'))
                                    ->icon('heroicon-o-map-pin'),

                                TextEntry::make('city.name')
                                    ->label(__('City'))
                                    ->icon('heroicon-o-home'),
                            ]),
                    ]),
        ]);
    }
}
