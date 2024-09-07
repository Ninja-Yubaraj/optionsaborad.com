<?php

namespace App\Filament\Admin\Resources\SearchLogResource\Pages;

use App\Filament\Admin\Resources\SearchLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSearchLogs extends ListRecords
{
    protected static string $resource = SearchLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
