<?php

namespace App\Filament\Admin\Resources;

use Carbon\Carbon;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use PhpParser\Node\Stmt\Label;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules\Password;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\UserResource\Pages;
use App\Filament\Admin\Resources\UserResource\RelationManagers;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Client Users';

    protected static ?int $navigationSort = 300;

    protected static ?string $modelLabel = 'Client Users';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', '!=', 'data')->where('role', '!=', 'admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('profile_picture')
                    ->label('Logo')
                    ->columnSpanFull()
                    ->image()
                    ->disk('public'),

                Forms\Components\TextInput::make('company_name')
                    ->label('Company Name')
                    ->maxLength(255)
                    ->columnSpan('full'),

                Forms\Components\TextInput::make('name')
                    ->maxLength(255)
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255)
                    ->required(),

                Forms\Components\TextInput::make('address')
                    ->maxLength(255)
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('city')
                    ->label('City')
                    ->maxLength(255),

                Forms\Components\TextInput::make('state')
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

                Forms\Components\TextInput::make('gst')
                    ->label('GST')
                    ->maxLength(255),

                Forms\Components\TextInput::make('password')
                    ->label(__('filament-panels::pages/auth/register.form.password.label'))
                    ->password()
                    ->revealable(filament()->arePasswordsRevealable())
                    ->requiredWith('create')
                    ->hiddenOn('edit')
                    ->rule(Password::default())
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->validationAttribute(__('filament-panels::pages/auth/register.form.password.validation_attribute')),
            
                Forms\Components\TextInput::make('password')
                    ->label(__('filament-panels::pages/auth/edit-profile.form.password.label'))
                    ->password()
                    ->hiddenOn('create')
                    ->revealable(filament()->arePasswordsRevealable())
                    ->rule(Password::default())
                    ->autocomplete('new-password')
                    ->dehydrated(fn ($state): bool => filled($state))
                    ->dehydrateStateUsing(fn ($state): string => Hash::make($state))
                    ->live(debounce: 500)
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->label('Created At')
                    ->date(),

                Tables\Columns\TextColumn::make('company_name')
                    ->searchable()
                    ->label('Company Name'),

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('address'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modal()
                    ->modalHeading('Edit Client User')
                    ->modalWidth('xl')
                    ->label('Edit Client User'),

                Tables\Actions\Action::make('activated_till')
                    ->label('Activated Till')
                    ->color('info')
                    ->icon('heroicon-m-adjustments-vertical')
                    ->form([
                        DatePicker::make('activated_till')
                            ->label('Activated Till')
                            ->native(false)
                            ->required(),
                    ])
                    ->action(function (User $record, $data) {
                        $record->is_active = 0;

                        $record->activated_till = Carbon::parse($data['activated_till']);
                        $record->save();

                        $formattedDate = $record->activated_till->format('Y-m-d');

                        Notification::make('success')
                            ->success()
                            ->title("The User's Activated Date Has Been Expand Till {$formattedDate}")
                            ->send();

                        return $record;
                    }),

                Tables\Actions\Action::make('is_active')
                    ->label(fn (User $record): string => $record->is_active === 0 ? 'Deactivate' : 'Reactivate')
                    ->color(fn (User $record): string => $record->is_active === 0 ? 'danger' : 'success')
                    ->icon(fn (User $record): string => $record->is_active === 0 ? 'heroicon-m-arrow-down-on-square-stack' : 'heroicon-m-arrow-up-on-square-stack')
                    ->action(function (User $record) {
                        if ($record->is_active == 0) {
                            $record->is_active = 1;
                            $record->save();

                        } else {
                            $record->is_active = 0;
                            $record->save();

                        }

                        Notification::make('success')
                            ->success()
                            ->title("The User's Status Is Successfuly Changed")
                            ->send();

                        return $record;
                    }),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            // 'create' => Pages\CreateUser::route('/create'),
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
