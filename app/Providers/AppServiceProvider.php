<?php

namespace App\Providers;

use Filament\Forms\Components\Field;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
        Field::macro('requiredOn', function ($field, $value, $on = true, $shouldHide = true) {
            /** @var BaseField $this */
            $value = (string) $value;

            $this->hidden(fn ($get) => 
                $shouldHide
                    ? !($on === ((string) $get($field) === $value))
                    : $on === ((string) $get($field) === $value)
            );
        
            // Dynamically set the `required` attribute based on the condition
            return $this->required(fn ($get) => 
                $on === ((string) $get($field) === $value)
            );
        });
        
    }
}
