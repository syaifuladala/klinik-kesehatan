<?php

namespace App\Filament\Resources\PatientResource\Pages;

use App\Filament\Resources\PatientResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPatients extends ListRecords
{
    protected static string $resource = PatientResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ButtonAction::make('download pdf')
                ->url(fn() => url('download/patient'))
                ->openUrlInNewTab(),
            Actions\CreateAction::make(),
        ];
    }
}
