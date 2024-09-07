<?php

namespace App\Filament\Admin\Resources\ForexRateResource\Pages;

use App\Filament\Admin\Resources\ForexRateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditForexRate extends EditRecord
{
    protected static string $resource = ForexRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
