<?php

namespace App\Filament\Widgets;

use App\Models\MedicalReport;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Jumlah Pemeriksaan Hari Ini', MedicalReport::where('date', Carbon::now()->format('Y-m-d'))->count()),
            Card::make('Jumlah Pemeriksaan Bulan Ini', MedicalReport::whereMonth('date', Carbon::now()->format('m'))->count()),
            Card::make('Total Semua Pemeriksaan', MedicalReport::count()),
        ];
    }
}
