<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('username')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->password()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->dehydrated(fn (?string $state) => filled($state))
                    ->maxLength(255),
                TextInput::make('plain_code')
                    ->maxLength(20)
                    ->label('Plain Access Code'),
                Toggle::make('is_admin')
                    ->label('Is Admin')
                    ->default(false),
                \Filament\Forms\Components\Select::make('groups')
                    ->multiple()
                    ->relationship('groups', 'name')
                    ->preload(),
            ]);
    }
}
