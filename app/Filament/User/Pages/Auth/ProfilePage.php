<?php

namespace App\Filament\User\Pages\Auth;

use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Pages\Auth\EditProfile as BaseAuth;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Tapp\FilamentTimezoneField\Forms\Components\TimezoneSelect;

class ProfilePage extends BaseAuth 
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected ?string $maxWidth = 'xl';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('profile_picture')
                    ->label('Logo')
                    ->columnSpanFull()
                    ->image()
                    ->disk('public'),

                TextInput::make('company_name')
                    ->label('Company Name')
                    ->maxLength(255)
                    ->columnSpan('full'),

                TextInput::make('name')
                    ->maxLength(255)
                    ->required(),

                TextInput::make('email')
                    ->email()
                    ->maxLength(255)
                    ->required(),

                TextInput::make('address')
                    ->maxLength(255)
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('city')
                    ->label('City')
                    ->maxLength(255),

                TextInput::make('state')
                    ->label('State')
                    ->maxLength(255),

                PhoneInput::make("contact")
                    ->label("Contact Phone")
                    ->defaultCountry('IN')
                    ->initialCountry('IN')
                    ->validateFor(
                        country: 'IN',
                        lenient: true,
                    ),

                TextInput::make('gst')
                    ->label('GST')
                    ->maxLength(255),

                ])
            ->columns(2);
    }
}
