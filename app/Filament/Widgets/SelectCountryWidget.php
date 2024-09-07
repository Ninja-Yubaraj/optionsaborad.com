<?php

namespace App\Filament\Widgets;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Widgets\Widget;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class SelectCountryWidget extends Widget implements HasForms

{
    use InteractsWithForms;

    protected static ?int $sort = -10;
    protected int|string|array $columnSpan = "full";
    protected static string $view = 'filament.widgets.select-country-widget';


    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill();
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('country')
                    ->native(false)
                    ->options([
                        "canada" => "Canada",
                        "italy" => "Italy",
                        "germany" => "Germany",
                        "UK" => "UK",
                        "france" => "France",
                        "new_zealand" => "New Zealand",
                        "poland" => "Poland",
                        "sweden" => "Sweden",
                        "USA" => "USA",
                        "australia" => "Australia",
                        "finland" => "Finland",
                        "ireland" => "Ireland",
                    ])
                    ->default("canada")
                    ->disableOptionWhen(fn ($value) => $value != 'canada')
                    ->required(),
            ])
            ->statePath('data');
    }
    

}
