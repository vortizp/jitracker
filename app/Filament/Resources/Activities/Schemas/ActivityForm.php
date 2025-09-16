<?php

namespace App\Filament\Resources\Activities\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ActivityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('milestone_id')
                     ->label('Tema')
                     ->required()
                     ->relationship('milestone', 'name')
                     ->preload(),
                TextInput::make('name')
                    ->label('Actividad')
                    ->required(),
                TextInput::make('order')
                    ->label('Orden')
                    ->required()
                    ->numeric()
                    ->default(1),
            ]);
    }
}
