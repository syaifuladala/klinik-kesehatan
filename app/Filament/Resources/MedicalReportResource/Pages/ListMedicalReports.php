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
        $url = 'download/medical-report';
        if (!empty(request()->input('tableFilters'))) {
            $filter = request()->input('tableFilters');
            $params = $filter['date'];
            if (!empty($params['date_from'])) {
                $dateParam = 'date[date_from]=' . $params['date_from'];
            } else if (!empty($params['date_until'])) {
                $dateParam = 'date[date_until]=' . $params['date_until'];
            } else if (!empty($params['date_from']) && !empty($params['date_until'])) {
                $dateParam = 'date[date_until]=' . $params['date_until'] . '&date[date_until]=' . $params['date_until'];
            }
            $url = 'download/medical-report?' . $dateParam;
        }

        return [
            Actions\ButtonAction::make('download pdf')
                ->url(fn () => url($url))
                ->openUrlInNewTab(),
            Actions\CreateAction::make(),
        ];
    }
}
