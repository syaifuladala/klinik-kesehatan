<?php

namespace App\Filament\Resources\MedicalReportResource\Pages;

use App\Filament\Resources\MedicalReportResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMedicalReports extends ListRecords
{
    protected static string $resource = MedicalReportResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
