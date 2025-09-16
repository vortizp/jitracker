<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name')
                    ->label('Primer apellido')
                    ->required(),
                TextInput::make('last_name')
                    ->label('Segundo apellido')
                    ->required(),
                TextInput::make('nick_name')
                    ->label('Nickname')
                    ->required(),
                TextInput::make('email')
                    ->label('Correo')
                    ->email()
                    ->default(null),
            ]);
    }
}
