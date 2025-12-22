<?php

namespace App\Filament\Resources\Events\Schemas;

use App\Models\City;
use App\Models\Company;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
               // Main Information
               Grid::make(2)
               ->schema([
                   TextInput::make('name')
                       ->label(__('Name'))
                       ->rules([
                           'string',
                           'regex:/^[^<>]*$/',
                           'required',
                           'min:4',
                           "max:255"
                       ]),

                   TextInput::make('description')
                       ->label(__('Description'))
                       ->required(),

                   TextInput::make('location')
                       ->label(__('Location'))
                       ->required(),

                   DateTimePicker::make('start_date')
                       ->label(__('Start Date'))
                       ->native(false)
                       ->required()
                       ->minDate(now())
                       ->displayFormat('Y-m-d h:i A'),

                   DateTimePicker::make('end_date')
                       ->label(__('End Date'))
                       ->native(false)
                       ->required()
                       ->minDate(fn (callable $get) => $get('start_date'))
                       ->displayFormat('Y-m-d h:i A'),

                   Select::make('company_id')
                       ->label(__('Company'))
                       ->options(Company::all()->pluck('name', 'id'))
                       ->required(),

                   Select::make('city_id')
                       ->label(__('City'))
                       ->options(City::all()->pluck('name', 'id'))
                       ->required(),
               ]),

               // Event Images
               SpatieMediaLibraryFileUpload::make('Images')
                   ->label(__("Event Images"))
                   ->collection('event-images')
                   ->multiple()
                   ->image()
                   ->columnSpanFull(),

               // Ticket Types
                Repeater::make('ticketTypes')
                    ->label('Ticket Types')
                    ->relationship()
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('name')->label('Name')->required(),
                                TextInput::make('price')->label('Price')->required()->minValue(0),
                                TextInput::make('quantity')->label('Quantity')->required()->minValue(1),
                            ])
                    ])
                   ->minItems(1)
                   ->createItemButtonLabel('Add Ticket Type')
                   ->columnSpanFull(),
           ]);
    }
}
