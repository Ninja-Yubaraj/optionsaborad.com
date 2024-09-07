<?php

namespace App\Filament\Admin\Resources\ForexRateResource\Pages;

use App\Filament\Admin\Resources\ForexRateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListForexRates extends ListRecords
{
    protected static string $resource = ForexRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modal()
                ->modalHeading('New Forex Rate')
                ->modalWidth('lg')
                ->label('New Forex Rate'),
        ];
    }
}
