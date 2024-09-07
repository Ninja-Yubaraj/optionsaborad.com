<?php

namespace App\Filament\Resources;

use App\Models;
use Filament\Forms;
use Filament\Tables;
use App\Models\Program;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Forms\Components\Wizard;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProgramResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProgramResource\RelationManagers;
use Filament\Forms\Components\TextInput;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make("Program Overview")
                        ->schema([
                            Forms\Components\Select::make("country_id")
                                ->relationship(
                                    name: 'country',
                                    titleAttribute: 'name'
                                )
                                ->searchable()
                                ->preload()
                                ->native(false)
                                ->hidden()
                                ->default(1)
                                ->afterStateUpdated(function (Set $set) {
                                    $set("city_id", null);
                                    $set("institute_id", null);
                                    $set("campus_id", null);
                                })
                                ->required(),

                            Forms\Components\Select::make("city_id")
                                ->relationship(
                                    name: 'city',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: fn (Builder $query, Get $get) => $query->where('country_id', $get('country_id')),
                                )
                                ->searchable()
                                ->preload()
                                ->native(false)
                                ->required()
                                ->afterStateUpdated(function (Set $set) {
                                    $set("institute_id", null);
                                    $set("campus_id", null);
                                })
                                ->suffixActions([
                                    Forms\Components\Actions\Action::make('create-city')
                                        ->icon('heroicon-m-plus')
                                        ->form([
                                            // Forms\Components\Select::make("country_id")
                                            //     ->label("Country")
                                            //     ->options(Models\Country::pluck('name', 'id'))
                                            //     ->searchable()
                                            //     ->required(),
                                            
                                            Forms\Components\TextInput::make("name")
                                                ->required()
                                        ])
                                        ->action(function ($data) {
                                            $data['country_id'] = 1;

                                            Models\City::create($data);

                                            Notification::make()
                                                ->title("Successful")
                                                ->success()
                                                ->send();
                                        }),
                                    
                                    Forms\Components\Actions\Action::make('delete')
                                        ->icon('heroicon-m-trash')
                                        ->color('danger')
                                        ->requiresConfirmation()
                                        ->action(function ($state) {
                                            Models\Institute::find($state)->delete();
                                            $state = null;
                                        })

                                ]),

                            Forms\Components\Select::make("institute_id")
                                ->relationship(
                                    name: 'institute',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: fn (Builder $query, Get $get) => $query->where('city_id', $get('city_id')),
                                )
                                ->searchable()
                                ->preload()
                                ->native(false)
                                ->required()
                                ->afterStateUpdated(function (Set $set) {
                                    $set("campus_id", null);
                                })
                                ->suffixActions([
                                    Forms\Components\Actions\Action::make('create-institute')
                                        ->icon('heroicon-m-plus')
                                        ->form([
                                            Forms\Components\Placeholder::make("City")
                                                ->content("Same as what you selected."),
                                            
                                            Forms\Components\TextInput::make("name")
                                                ->required()
                                        ])
                                        ->action(function ($data, Get $get) {
                                            $data['city_id'] = $get("city_id");

                                            if(!$data['city_id']) {
                                                Notification::make()
                                                    ->title("Failed")
                                                    ->body("Please select a city!")
                                                    ->danger()
                                                    ->send();    

                                                return;
                                            }

                                            Models\Institute::create($data);

                                            Notification::make()
                                                ->title("Successful")
                                                ->success()
                                                ->send();
                                        }),

                                        Forms\Components\Actions\Action::make('delete')
                                            ->icon('heroicon-m-trash')
                                            ->color('danger')
                                            ->requiresConfirmation()
                                            ->action(function ($state) {
                                                Models\Institute::find($state)->delete();
                                            })
                            


                                    ]),

                            
                            Forms\Components\Select::make("campus_id")
                                ->relationship(
                                    name: 'campus',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: fn (Builder $query, Get $get) => $query->where('institute_id', $get('institute_id')),
                                )
                                ->searchable()
                                ->preload()
                                ->native(false)
                                ->required()
                                ->suffixActions([
                                    Forms\Components\Actions\Action::make('create-campus')
                                        ->icon('heroicon-m-plus')
                                        ->form([
                                            Forms\Components\Placeholder::make("Institute")
                                                ->content("Same as what you selected."),
                                            
                                            Forms\Components\TextInput::make("name")
                                                ->required()
                                        ])
                                        ->action(function ($data, Get $get) {
                                            $data['institute_id'] = $get("institute_id");

                                            if(!$data['institute_id']) {
                                                Notification::make()
                                                    ->title("Failed")
                                                    ->body("Please select a city!")
                                                    ->danger()
                                                    ->send();    

                                                return;
                                            }

                                            Models\Campus::create($data);

                                            Notification::make()
                                                ->title("Successful")
                                                ->success()
                                                ->send();
                                        }),

                                        Forms\Components\Actions\Action::make('delete')
                                            ->icon('heroicon-m-trash')
                                            ->color('danger')
                                            ->requiresConfirmation()
                                            ->action(function ($state) {
                                                Models\Campus::find($state)->delete();
                                                $state = null;
                                            })
                            


                                    ]),
    
                                    
                            Forms\Components\TextInput::make("app_fees_cad")
                                ->label("App. Fees.")
                                ->numeric()
                                ->suffix("CAD")
                                ->required(),

                            Forms\Components\TextInput::make("fees")
                                ->label("Fees.")
                                ->numeric()
                                ->suffix("CAD")
                                ->required(),

                            Forms\Components\Section::make("Program Information")
                                ->schema([
                                    Forms\Components\TextInput::make("program_code")
                                        ->label("Program Code")
                                        ->required(),

                                    Forms\Components\TextInput::make("program_name")
                                        ->label("Program Name")
                                        ->required(),

                                    Forms\Components\Select::make("program_level_id")
                                        ->relationship(
                                            name: 'level',
                                            titleAttribute: 'label',
                                        )
                                        ->searchable()
                                        ->preload()
                                        ->native(false)
                                        ->required()
                                        ->suffixActions([
                                            Forms\Components\Actions\Action::make('create-program-level')
                                                ->icon('heroicon-m-plus')
                                                ->form([
                                                    Forms\Components\TextInput::make("label")
                                                        ->required()
                                                ])
                                                ->action(function ($data, Get $get) {
                                                    Models\ProgramLevel::create($data);
        
                                                    Notification::make()
                                                        ->title("Successful")
                                                        ->success()
                                                        ->send();
                                                }),
        
                                                Forms\Components\Actions\Action::make('delete')
                                                    ->icon('heroicon-m-trash')
                                                    ->color('danger')
                                                    ->requiresConfirmation()
                                                    ->action(function ($state) {
                                                        Models\ProgramLevel::find($state)->delete();
                                                        $state = null;
                                                    })
                                    
        
        
                                            ]),
                                    
                                    Forms\Components\Select::make("duration")
                                    ->relationship(
                                        name: 'duration',
                                        titleAttribute: 'label',
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->native(false)
                                    ->required()
                                    ->suffixActions([
                                        Forms\Components\Actions\Action::make('create-duration')
                                            ->icon('heroicon-m-plus')
                                            ->form([
                                                Forms\Components\TextInput::make("label")
                                                    ->required()
                                            ])
                                            ->action(function ($data, Get $get) {
                                                Models\Duration::create($data);
    
                                                Notification::make()
                                                    ->title("Successful")
                                                    ->success()
                                                    ->send();
                                            }),
    
                                            Forms\Components\Actions\Action::make('delete')
                                                ->icon('heroicon-m-trash')
                                                ->color('danger')
                                                ->requiresConfirmation()
                                                ->action(function ($state) {
                                                    Models\Duration::find($state)->delete();
                                                    $state = null;
                                                })
                                
    
    
                                        ]),

                                    Forms\Components\Select::make("intake_id")
                                        ->relationship(
                                            name: 'intake',
                                            titleAttribute: 'label',
                                        )
                                        ->searchable()
                                        ->preload()
                                        ->native(false)
                                        ->required()
                                        ->suffixActions([
                                            Forms\Components\Actions\Action::make('create-intake')
                                                ->icon('heroicon-m-plus')
                                                ->form([
                                                    Forms\Components\TextInput::make("label")
                                                        ->required()
                                                ])
                                                ->action(function ($data, Get $get) {
                                                    Models\Intake::create($data);
        
                                                    Notification::make()
                                                        ->title("Successful")
                                                        ->success()
                                                        ->send();
                                                }),
        
                                                Forms\Components\Actions\Action::make('delete')
                                                    ->icon('heroicon-m-trash')
                                                    ->color('danger')
                                                    ->requiresConfirmation()
                                                    ->action(function ($state) {
                                                        Models\Intake::find($state)->delete();
                                                        $state = null;
                                                    })
                                    
        
        
                                            ]),
    

                            ])->columns(2),


                            Forms\Components\Section::make("Co-Op & Conditional Information")
                                ->schema([
                                    Forms\Components\Select::make("conditional")
                                        ->label("Conditional")
                                        ->options([
                                            true => "Yes",
                                            false => "No"
                                        ])
                                        ->default(false)
                                        ->native(false)
                                        ->required(),

                                    Forms\Components\Select::make("co_op")
                                        ->label("Co-Op")
                                        ->options([
                                            true => "Yes",
                                            false => "No"
                                        ])
                                        ->default(false)
                                        ->native(false)
                                        ->live()
                                        ->required(),

                                    Forms\Components\TextInput::make("co_op_duration")
                                        ->label("Co-Op Duration")
                                        ->requiredOn('co_op', true, true, true),
                                ])
                        
                        
                        ])
                        ->columns(3),
                    
                    Wizard\Step::make("Advanced")
                        ->schema([
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make("ave_tat_bucket_in_days")
                                    ->label("Ave. TAT Bucket")
                                    ->numeric()
                                    ->suffix("Day(s)")
                                    ->required(),

                                Forms\Components\Select::make("degrees")
                                    ->relationship(
                                        name: 'degrees',
                                        titleAttribute: 'name',
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->multiple()
                                    ->native(false)
                                    ->required()
                                    ->suffixActions([
                                        Forms\Components\Actions\Action::make('create-degree')
                                            ->icon('heroicon-m-plus')
                                            ->form([
                                                Forms\Components\TextInput::make("name")
                                                    ->required()
                                            ])
                                            ->action(function ($data, Get $get) {
                                                Models\Degree::create($data);
    
                                                Notification::make()
                                                    ->title("Successful")
                                                    ->success()
                                                    ->send();
                                            }),
    
                                            Forms\Components\Actions\Action::make('delete')
                                                ->icon('heroicon-m-trash')
                                                ->color('danger')
                                                ->requiresConfirmation()
                                                ->action(function ($state) {
                                                    Models\Degree::find($state)->delete();
                                                    $state = null;
                                                })
                                
    
    
                                        ]),

                            ])->columns(2),

                            Forms\Components\Group::make([
                                Forms\Components\Select::make("streams")
                                    ->relationship(
                                        name: 'streams',
                                        titleAttribute: 'label',
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->native(false)
                                    ->multiple()
                                    ->required()
                                    ->suffixActions([
                                        Forms\Components\Actions\Action::make('create-stream')
                                            ->icon('heroicon-m-plus')
                                            ->form([
                                                Forms\Components\TextInput::make("label")
                                                    ->required()
                                            ])
                                            ->action(function ($data, Get $get) {
                                                Models\Stream::create($data);
    
                                                Notification::make()
                                                    ->title("Successful")
                                                    ->success()
                                                    ->send();
                                            }),
    
                                            Forms\Components\Actions\Action::make('delete')
                                                ->icon('heroicon-m-trash')
                                                ->color('danger')
                                                ->requiresConfirmation()
                                                ->action(function ($state) {
                                                    Models\Stream::find($state)->delete();
                                                    $state = null;
                                                })
                                
    
    
                                        ]),

                                Forms\Components\TextInput::make("cgpa_bucket")
                                    ->label("CGPA Bucket")
                                    ->numeric()
                                    ->required(),

                                
                                Forms\Components\TextInput::make("percentage_bucket")
                                    ->label("Percentage% Bucket")
                                    ->required(),

                            ])->columns(3),

                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make("study_gap")
                                    ->label("Study Gap")
                                    ->numeric()
                                    ->suffix("Month(s)")
                                    ->required(),

                                Forms\Components\TextInput::make("backlogs")
                                    ->label("Backlogs")
                                    ->numeric()
                                    ->required(),

                                Forms\Components\Select::make("moi_accepted")
                                    ->label("MOI Accepted")
                                    ->options([
                                        true => "Yes",
                                        false => "No"
                                    ])
                                    ->default(false)
                                    ->native(false)
                                    ->required(),

                            ])->columns(3)
                        ])
                        ->columns(1),


                        Wizard\Step::make("Final Step")
                            ->schema([
                                Forms\Components\Repeater::make("exam")
                                    ->schema([
                                        Forms\Components\Select::make('exam')
                                            ->options([
                                                "DUOLINGO" => "DUOLINGO",
                                                "GMAT" => "GMAT",
                                                "GRE" => "GRE",
                                                "IELTS" => "IELTS",
                                                "PTE" => "PTE",
                                                "SAT" => "SAT",
                                                "TOEFL" => "TOEFL",
                                                "Others" => "Others",
                                            ])
                                            ->native(false)
                                            ->required(),

                                        Forms\Components\TextInput::make('listening')
                                            ->numeric()
                                            ->required(),

                                        Forms\Components\TextInput::make('speaking')
                                            ->numeric()
                                            ->required(),

                                        Forms\Components\TextInput::make('reading')
                                            ->numeric()
                                            ->required(),

                                        Forms\Components\TextInput::make('writing')
                                            ->numeric()
                                            ->required(),

                                        Forms\Components\TextInput::make('avg')
                                            ->numeric()
                                            ->label('Avg.')
                                            ->required(),

                                    ])->columns(3)
                            ])
                    ]),

                    
                                
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->recordAction(Tables\Actions\ViewAction::class)
            ->columns([
                Tables\Columns\TextColumn::make('country.name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('city.name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('institute.name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('campus.name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('program_name')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\ViewAction::make()
                //     ->color(Color::Teal),

                Tables\Actions\ViewAction::make()
                    ->form([
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Select::make('country_id')
                                    ->relationship(
                                        name: 'country',
                                        titleAttribute: 'name',
                                    )
                                    ->label('Country')
                                    ->native(false),

                                Forms\Components\Select::make('city_id')
                                    ->relationship(
                                        name: 'city',
                                        titleAttribute: 'name',
                                    )
                                    ->label('City')
                                    ->native(false),

                                Forms\Components\Select::make('institute_id')
                                    ->relationship(
                                        name: 'institute',
                                        titleAttribute: 'name',
                                    )
                                    ->label('Institute')
                                    ->native(false),

                                Forms\Components\Select::make('campus_id')
                                    ->relationship(
                                        name: 'campus',
                                        titleAttribute: 'name',
                                    )
                                    ->label('Campus')
                                    ->native(false),

                                Forms\Components\TextInput::make('program_name')
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('program_code'),
                                
                                Forms\Components\Select::make('program_level_id')
                                    ->relationship(
                                        name: 'level',
                                        titleAttribute: 'label',
                                    )
                                    ->label('Program Level')
                                    ->native(false),

                                Forms\Components\Select::make('duration_id')
                                    ->relationship(
                                        name: 'duration',
                                        titleAttribute: 'label',
                                    )
                                    ->label('Duration')
                                    ->native(false),

                                Forms\Components\Select::make('intake_id')
                                    ->relationship(
                                        name: 'intake',
                                        titleAttribute: 'label',
                                    )
                                    ->label('Intake')
                                    ->native(false),

                                Forms\Components\Select::make('degrees')
                                    ->relationship(
                                        name: 'degrees',
                                        titleAttribute: 'name',
                                    )
                                    ->label('Degrees')
                                    ->multiple()
                                    ->native(false),

                                Forms\Components\Select::make('streams')
                                    ->relationship(
                                        name: 'streams',
                                        titleAttribute: 'label',
                                    )
                                    ->label('Streams')
                                    ->multiple()
                                    ->native(false),

                                Forms\Components\TextInput::make('cgpa_bucket')
                                    ->label("CGPA Bucket")
                                    ->numeric(),

                                Forms\Components\TextInput::make('percentage_bucket')
                                    ->label("Percentage Bucket")
                                    ->numeric()
                                    ->suffix('%'),

                                Forms\Components\TextInput::make('study_gap')
                                    ->label("Study Gap")
                                    ->numeric()
                                    ->suffix('Months'),

                                Forms\Components\TextInput::make('backlogs')
                                    ->label("Backlogs")
                                    ->numeric(),

                                Forms\Components\Select::make("moi_accepted")
                                    ->label("MOI Accepted")
                                    ->options([
                                        true => "Yes",
                                        false => "No"
                                    ])
                                    ->native(false),

                                Forms\Components\Select::make("conditional")
                                    ->label("Conditional")
                                    ->options([
                                        true => "Yes",
                                        false => "No"
                                    ])
                                    ->native(false),

                                Forms\Components\Select::make("co_op")
                                    ->label("Co-Op")
                                    ->options([
                                        true => "Yes",
                                        false => "No"
                                    ])
                                    ->columnSpan(function ($state) {
                                        if ($state) {
                                            return 'half';

                                        } else {
                                            return 'full';
                                        }
                                    })
                                    ->native(false),

                                Forms\Components\TextInput::make("co_op_duration")
                                    ->label("Co-Op Duration")
                                    ->requiredOn('co_op', true, true, true),

                                Forms\Components\TextInput::make("app_fees_cad")
                                    ->label("App. Fees.")
                                    ->numeric()
                                    ->suffix("CAD"),

                                Forms\Components\TextInput::make("fees")
                                    ->label("Fees.")
                                    ->numeric()
                                    ->suffix("CAD"),

                            ])
                            ->columns(2),

                            Forms\Components\Repeater::make("exam")
                                    ->schema([
                                        Forms\Components\Select::make('exam')
                                            ->options([
                                                "DUOLINGO" => "DUOLINGO",
                                                "GMAT" => "GMAT",
                                                "GRE" => "GRE",
                                                "IELTS" => "IELTS",
                                                "PTE" => "PTE",
                                                "SAT" => "SAT",
                                                "TOEFL" => "TOEFL",
                                                "Others" => "Others",
                                            ])
                                            ->native(false)
                                            ->required(),

                                        Forms\Components\TextInput::make('listening')
                                            ->numeric()
                                            ->required(),

                                        Forms\Components\TextInput::make('speaking')
                                            ->numeric()
                                            ->required(),

                                        Forms\Components\TextInput::make('reading')
                                            ->numeric()
                                            ->required(),

                                        Forms\Components\TextInput::make('writing')
                                            ->numeric()
                                            ->required(),
                                            
                                        Forms\Components\TextInput::make('avg')
                                            ->numeric()
                                            ->label('Avg.')
                                            ->required(),

                                    ])
                                    ->columns(3),
                    ]),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->searchable()
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
            'create' => Pages\CreateProgram::route('/create'),
            'edit' => Pages\EditProgram::route('/{record}/edit'),
        ];
    }
}
