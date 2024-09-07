<?php

namespace App\Filament\Admin\Resources\DataEntryResource\Pages;

use App\Filament\Admin\Resources\DataEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDataEntries extends ListRecords
{
    protected static string $resource = DataEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modal()
                ->modalHeading('New Data Entry')
                ->modalWidth('lg')
                ->label('New Data Entry'),
        ];
    }
}
