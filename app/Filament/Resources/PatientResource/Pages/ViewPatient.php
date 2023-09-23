<?php

namespace App\Filament\Resources\PatientResource\Pages;

use App\Filament\Resources\PatientResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPatient extends ViewRecord
{
    protected static string $resource = PatientResource::class;

    protected function getActions(): array
    {
        $url = url()->current();
        $segments = explode('/', rtrim($url, '/'));
        $id = end($segments);

        return [
            Actions\ButtonAction::make('download pdf')
                ->url(fn () => url('download/patient/'.$id))
                ->openUrlInNewTab(),
        ];
    }
}
