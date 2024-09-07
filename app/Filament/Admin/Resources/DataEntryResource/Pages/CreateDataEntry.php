<?php

namespace App\Filament\Admin\Resources\DataEntryResource\Pages;

use App\Filament\Admin\Resources\DataEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDataEntry extends CreateRecord
{
    protected static string $resource = DataEntryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['role'] = 'data';
    
        return $data;
    }

}
