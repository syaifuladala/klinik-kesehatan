<?php

namespace App\Filament\Resources\MedicalReportResource\Pages;

use App\Filament\Resources\MedicalReportResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Collection;

class ListMedicalReports extends ListRecords
{
    protected static string $resource = MedicalReportResource::class;

    protected function getActions(): array
    {
        $dateFrom = null;
        $dateUntil = null;
        $url = 'download/medical-report';

        $record = $this->getFilteredTableQuery();
        $date = $this->removePercentageElements($record->getBindings());
        if (count($date) > 0) {
            $dateFrom = !empty($date[0]) ? $date[0] : null;
            $dateUntil = !empty($date[1]) ? $date[1] : null;
            $url = 'download/medical-report?date_from='.$dateFrom.'&date_until='.$dateUntil;
        }

        return [
            Actions\ButtonAction::make('download pdf')
                ->url(fn () => url($url))
                ->openUrlInNewTab(),
            Actions\CreateAction::make(),
        ];
    }

    function removePercentageElements($array) {
        return array_values(array_filter($array, function($element) {
            return strpos($element, '%') === false;
        }));
    }
}
