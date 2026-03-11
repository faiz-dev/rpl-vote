<?php

namespace App\Filament\Resources\Options\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('voting_event_id')
                    ->relationship('votingEvent', 'title')
                    ->required(),
                TextInput::make('candidate_name')
                    ->required(),
                \Filament\Forms\Components\FileUpload::make('photo')
                    ->image()
                    ->directory('candidates'),
                Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }
}
