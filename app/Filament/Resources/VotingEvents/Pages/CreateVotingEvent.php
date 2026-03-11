<?php

namespace App\Filament\Resources\VotingEvents\Pages;

use App\Filament\Resources\VotingEvents\VotingEventResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVotingEvent extends CreateRecord
{
    protected static string $resource = VotingEventResource::class;
}
