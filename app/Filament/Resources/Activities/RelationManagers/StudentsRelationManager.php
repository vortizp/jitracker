<?php

namespace App\Filament\Resources\Activities\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'Students';

    protected static ?string $pluralModelLabel = "Estudiantes";

    protected static ?string $modelLabel = "Estudiante";

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                /*TextInput::make('first_name')
                    ->required(),
                TextInput::make('last_name')
                    ->required(),*/
                TextInput::make('nick_name')
                    ->label('Nickname')
                    ->required(),
                /*TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->default(null),*/
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nick_name')
            ->columns([
                /*TextColumn::make('first_name')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->searchable(),*/
                TextColumn::make('nick_name')
                    ->label('Nickname')
                    ->searchable(),
                /*TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),*/
                ToggleColumn::make('completed')
                    ->label('Completado en tiempo?')
                    ->getStateUsing(fn ($record) => $record->pivot->completed)
                    ->afterStateUpdated(function ($record, $state) {
                        $record->activities()->updateExistingPivot($this->getOwnerRecord()->id, [
                            'completed' => $state,
                            'completed_at' => $state ? now() : null,
                        ]);
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AttachAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DetachAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
