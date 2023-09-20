<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ButtonAction::make('download pdf')
                ->url(fn() => url('download/user'))
                ->openUrlInNewTab(),
            Actions\CreateAction::make(),

        ];
    }
}
