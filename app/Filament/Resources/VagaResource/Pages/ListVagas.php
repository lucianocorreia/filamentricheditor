<?php

namespace App\Filament\Resources\VagaResource\Pages;

use App\Filament\Resources\VagaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVagas extends ListRecords
{
    protected static string $resource = VagaResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
