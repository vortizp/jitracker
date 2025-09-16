<?php

namespace App\Filament\Resources\Milestones;

use App\Filament\Resources\Milestones\RelationManagers\ActivitiesRelationManager;
use App\Filament\Resources\Milestones\Pages\CreateMilestone;
use App\Filament\Resources\Milestones\Pages\EditMilestone;
use App\Filament\Resources\Milestones\Pages\ListMilestones;
use App\Filament\Resources\Milestones\Schemas\MilestoneForm;
use App\Filament\Resources\Milestones\Tables\MilestonesTable;
use App\Models\Milestone;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MilestoneResource extends Resource
{
    protected static ?string $model = Milestone::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedComputerDesktop;

    protected static ?string $recordTitleAttribute = 'Milestone';

    protected static ?string $pluralModelLabel = "Temas";

    protected static ?string $modelLabel = "Tema";

    public static function form(Schema $schema): Schema
    {
        return MilestoneForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MilestonesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ActivitiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMilestones::route('/'),
            'create' => CreateMilestone::route('/create'),
            'edit' => EditMilestone::route('/{record}/edit'),
        ];
    }
}
