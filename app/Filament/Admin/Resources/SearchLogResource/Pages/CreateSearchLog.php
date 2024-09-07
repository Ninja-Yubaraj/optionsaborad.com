<?php

namespace App\Filament\Admin\Resources\SearchLogResource\Pages;

use App\Filament\Admin\Resources\SearchLogResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSearchLog extends CreateRecord
{
    protected static string $resource = SearchLogResource::class;
}
