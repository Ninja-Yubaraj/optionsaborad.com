<?php

namespace App\Filament\Admin\Resources\SearchLogResource\Pages;

use App\Filament\Admin\Resources\SearchLogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSearchLog extends EditRecord
{
    protected static string $resource = SearchLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
