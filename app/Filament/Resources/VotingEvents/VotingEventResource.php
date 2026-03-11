<?php

namespace App\Filament\Resources\VotingEvents;

use App\Filament\Resources\VotingEvents\Pages\CreateVotingEvent;
use App\Filament\Resources\VotingEvents\Pages\EditVotingEvent;
use App\Filament\Resources\VotingEvents\Pages\ListVotingEvents;
use App\Filament\Resources\VotingEvents\Schemas\VotingEventForm;
use App\Filament\Resources\VotingEvents\Tables\VotingEventsTable;
use App\Models\VotingEvent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VotingEventResource extends Resource
{
    protected static ?string $model = VotingEvent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return VotingEventForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VotingEventsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\VotingEvents\RelationManagers\OptionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVotingEvents::route('/'),
            'create' => CreateVotingEvent::route('/create'),
            'edit' => EditVotingEvent::route('/{record}/edit'),
        ];
    }
}
