<?php

namespace App\Filament\Resources\VotingEvents\Pages;

use App\Filament\Resources\VotingEvents\VotingEventResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVotingEvent extends EditRecord
{
    protected static string $resource = VotingEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
