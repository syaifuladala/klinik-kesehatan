<?php

namespace App\Filament\Widgets;

use App\Models\Patient;
use Carbon\Carbon;
use Filament\Widgets\DoughnutChartWidget;

class PatientChart extends DoughnutChartWidget
{
    protected static ?string $heading = 'Total Pasien';
    protected static ?string $pollingInterval = '10s';
    protected static ?string $maxHeight = '300px';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $query = Patient::get();
        $skhpn = $query->where('type', 'skhpn')->count();
        $konsultasi = $query->where('type', 'konsultasi')->count();
        $label = ['SKHPN', 'Konsultasi'];

        return [
            'datasets' => [
                [
                    'label' => $label,
                    'data' => [$skhpn, $konsultasi],
                    'backgroundColor' => [
                        '#9b59b6',
                        '#e67e22',
                    ],
                ],
            ],
            'labels' => $label,

        ];
    }
}
