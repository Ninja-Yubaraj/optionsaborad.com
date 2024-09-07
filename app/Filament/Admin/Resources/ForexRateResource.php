<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\ForexRate;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\ForexRateResource\Pages;
use App\Filament\Admin\Resources\ForexRateResource\RelationManagers;

class ForexRateResource extends Resource
{
    protected static ?string $model = ForexRate::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    protected static ?int $navigationSort = 400;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('from')
                    ->maxLength(20)
                    ->placeholder('Enter From (Currency)')
                    ->required(),

                Forms\Components\TextInput::make('to')
                    ->maxLength(20)
                    ->placeholder('Enter To (Currency)')
                    ->required(),

                Forms\Components\TextInput::make('rate')
                    ->numeric()
                    ->placeholder('Enter Rate (83.95, e.g)')
                    ->required(),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('from'),
                Tables\Columns\TextColumn::make('to'),

                Tables\Columns\TextColumn::make('rate')
                    ->numeric(2)
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modal()
                    ->modalHeading('Edit Forex Rate')
                    ->modalWidth('lg'),

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
            'index' => Pages\ListForexRates::route('/'),
            // 'create' => Pages\CreateForexRate::route('/create'),
            // 'edit' => Pages\EditForexRate::route('/{record}/edit'),
        ];
    }
}
