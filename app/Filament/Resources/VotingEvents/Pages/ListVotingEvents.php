<?php

namespace App\Filament\Resources\VotingEvents\Pages;

use App\Filament\Resources\VotingEvents\VotingEventResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVotingEvents extends ListRecords
{
    protected static string $resource = VotingEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
