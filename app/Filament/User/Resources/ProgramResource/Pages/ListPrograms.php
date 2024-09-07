<?php

namespace App\Filament\User\Resources\ProgramResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Redirect;
use Filament\Resources\Pages\ListRecords;
use App\Filament\User\Resources\ProgramResource;

class ListPrograms extends ListRecords
{
    protected static string $resource = ProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            // Actions\Action::make('back')
            //     ->button()
            //     ->action(function () {
            //         return Redirect::back();
            //     }),
        ];
    }
}
