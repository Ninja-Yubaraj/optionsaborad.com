<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SearchLogResource\Pages;
use App\Filament\Admin\Resources\SearchLogResource\RelationManagers;
use App\Models\SearchLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SearchLogResource extends Resource
{
    protected static ?string $model = SearchLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';

    protected static ?int $navigationSort = 350;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('User')
                    ->searchable()
                    ->required(),

                Forms\Components\Group::make()->schema([

                    Forms\Components\TextInput::make('backlogs')
                        ->label('Backlogs'), 

                    Forms\Components\TextInput::make('study_gap')
                        ->label('Study Gap'),

                ])
                ->columns(2),
                
                Forms\Components\TextInput::make('percentage')
                    ->label('Percentage'),

                Forms\Components\TextInput::make('exam')
                        ->label('Exam'),

                Forms\Components\Section::make()->schema([
                    Forms\Components\TextInput::make('listening')
                        ->label('Listening Score'),

                    Forms\Components\TextInput::make('speaking')
                        ->label('Speaking Score'),

                    Forms\Components\TextInput::make('reading')
                        ->label('Reading Score'),

                    Forms\Components\TextInput::make('writing')
                        ->label('Writing Score'),

                ])
                ->columns(4),

            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label("Date")
                    ->date(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label("User's Name")
                    ->searchable(),

                Tables\Columns\TextColumn::make('exam')
                    ->label("Exam")
                    ->searchable(),

                Tables\Columns\TextColumn::make('backlogs')
                    ->label("Backlogs")
                    ->sortable(),

                Tables\Columns\TextColumn::make('study_gap')
                    ->label("Study Gap")
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('percentage')
                    ->label("Percentage Bucket")
                    ->sortable(),

            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->native(false),

                        Forms\Components\DatePicker::make('created_until')
                           ->native(false),

                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->color('primary'),
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
            'index' => Pages\ListSearchLogs::route('/'),
            'create' => Pages\CreateSearchLog::route('/create'),
            'edit' => Pages\EditSearchLog::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }
}
