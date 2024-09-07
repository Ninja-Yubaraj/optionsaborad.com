<?php

namespace App\Filament\User\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Program;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\User\Resources\ProgramResource\Pages;
use App\Filament\User\Resources\ProgramResource\RelationManagers;
use App\Models\Degree;
use App\Models\Stream;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';

    protected static ?string $navigationLabel = 'Programs Search';

    protected static ?string $modelLabel = 'Programs Search';

    protected static bool $shouldRegisterNavigation = false;

    public static ?bool $filtersActive = false;

    public static function getEloquentQuery(): Builder
    {
        if (!request()->filled('tableFilters')) {
            return parent::getEloquentQuery()->where('id', null);
        
        } else {
            return parent::getEloquentQuery();

        }
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('institute.name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('campus.name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('program_name')
                    ->searchable()
                    ->label('Program Name'),

                Tables\Columns\TextColumn::make('duration.label')
                    ->sortable()
                    ->label('Duration'),

                Tables\Columns\TextColumn::make('co_op')
                    ->sortable()
                    ->label('Co Op'),
            ])
            ->filters([
                Tables\Filters\Filter::make('all')
                    ->form([
                        Forms\Components\TextInput::make('backlogs')
                            ->numeric()
                            ->placeholder('e.g. 5, 12'),
        
                        Forms\Components\TextInput::make('study_gap')
                            ->suffix('Months')
                            ->label('Study Gap')
                            ->placeholder('e.g. 1, 3')
                            ->numeric(),

                        Forms\Components\Select::make('exam')
                            ->options([
                                "Duolingo" => "Duolingo",
                                "GMAT" => "GMAT",
                                "GRE" => "GRE",
                                "IELTS" => "IELTS",
                                "PTE" => "PTE",
                                "SAT" => "SAT",
                                "TOEFL" => "TOEFL",
                                "Others" => "Others",
                            ])
                            ->native(false),
            
                        Forms\Components\TextInput::make('listening')
                            ->numeric(),
            
                        Forms\Components\TextInput::make('speaking')
                            ->numeric(),
            
                        Forms\Components\TextInput::make('reading')
                            ->numeric(),
            
                        Forms\Components\TextInput::make('writing')
                            ->numeric(),
            
                        Forms\Components\TextInput::make('avg')
                            ->numeric()
                            ->label('Avg.'),

                        Forms\Components\TextInput::make('percentage')
                            ->suffix('%')
                            ->numeric()
                            ->placeholder('e.g. 10, 30, 60'),

                        Forms\Components\Select::make('degrees')
                            ->options(Degree::all()->pluck('name', 'id')->toArray())
                            ->label('Degrees')
                            ->multiple()
                            ->native(false),

                        Forms\Components\Select::make('streams')
                            ->options(Stream::all()->pluck('label', 'id')->toArray())
                            ->label('Streams')
                            ->multiple()
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if ($data['backlogs']) {
                            $query->whereRaw("CAST(backlogs AS UNSIGNED) >= ?", [(int) $data['backlogs']]);
                        }

                        if ($data['study_gap']) {
                            $query->whereRaw("CAST(study_gap AS UNSIGNED) >= ?", [(int) $data['study_gap']]);
                        }

                        if ($data['exam']) {
                            $query->whereJsonContains('exam', ['exam' => $data['exam']]);
                        }

                        // Other Queries Here
                        if ($data['percentage']) {
                            $query->whereRaw("CAST(percentage_bucket AS UNSIGNED) <= ?", [(int) $data['percentage']]);
                        }

                        if (request()->input('tableFilters.all.streams')) {
                            $data['streams'] = json_decode(request()->input('tableFilters.all.streams'));
                        }

                        if ($data['streams']) {
                            $query->whereHas('streams', function ($query) use ($data) {
                                $query->whereIn('id', $data['streams']);
                            });
                        }

                        if (request()->input('tableFilters.all.degrees')) {
                            $data['degrees'] = json_decode(request()->input('tableFilters.all.degrees'));
                        }

                        if ($data['degrees']) {
                            $query->whereHas('degrees', function ($query) use ($data) {
                                $query->whereIn('id', $data['degrees']);
                            });
                        }

                        // Needs To be last query
                        if ($data['exam'] && $data['listening'] && $data['speaking'] && $data['reading'] && $data['writing']) {
                            $FilteredPrograms = $query->get();
                            $FilteredIds = [];

                            foreach ($FilteredPrograms as $program) {
                                for ($i = 0; $i < 10; $i++) {
                                    try {
                                        $examJson = $program->exam[$i];

                                        if (isset($examJson)) {
                                            // $examJson = json_decode($examJson, true);

                                            if ($examJson['listening'] <= $data['listening'] &&
                                                $examJson['speaking'] <= $data['speaking'] &&
                                                $examJson['reading'] <= $data['reading'] &&
                                                $examJson['writing'] <= $data['writing'] &&
                                                $examJson['exam'] == $data['exam']) {
                                                    $FilteredIds[] = $program->id;
                                                    break;
                                            }
                                        }

                                    } catch (\Exception $e) {
                                        
                                    }
                                }
                            }

                            $query->whereIn('id', $FilteredIds);
                        }

                        return $query;
                    })

            ], layout: FiltersLayout::Hidden)
            ->filtersFormColumns(1)

            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPrograms::route('/'),
            // 'create' => Pages\CreateProgram::route('/create'),
            // 'edit' => Pages\EditProgram::route('/{record}/edit'),
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
