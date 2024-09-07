<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules\Password;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\DataEntryResource\Pages;
use App\Filament\Admin\Resources\DataEntryResource\RelationManagers;

class DataEntryResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Data Entry';

    protected static ?int $navigationSort = 200;

    protected static ?string $modelLabel = 'Data Entry';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', 'data');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->maxLength(255)
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->maxLength(255)
                    ->email()
                    ->required(),

                Forms\Components\TextInput::make('address')
                    ->maxLength(255)
                    ->columnSpan('full'),

                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->columnSpanFull()
                    ->required()
                    ->rule(Password::default())
                    ->validationAttribute(__('filament-panels::pages/auth/register.form.password.validation_attribute')),
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('programs_count')
                    ->sortable()
                    ->numeric(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modal()
                    ->modalHeading('New Data Entry')
                    ->modalWidth('lg')
                    ->label('New Data Entry'),

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
            'index' => Pages\ListDataEntries::route('/'),
            // 'create' => Pages\CreateDataEntry::route('/create'),
            // 'edit' => Pages\EditDataEntry::route('/{record}/edit'),
        ];
    }
}
