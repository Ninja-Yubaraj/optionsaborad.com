<?php

namespace App\Filament\User\Pages;

use App\Models\Degree;
use App\Models\SearchLog;
use App\Models\Stream;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class ProgramSearch extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = []; 

    protected static string $view = 'filament.user.pages.program-search';

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';

    protected static ?string $navigationLabel = 'Programs Search';

    protected static ?string $modelLabel = 'Programs Search';

    protected static ?int $sort = 100;

    public function mount(): void 
    {
        $this->form->fill();
    }
 
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Select::make('degrees')
                                    ->options(Degree::all()->pluck('name', 'id')->toArray())
                                    ->label('Degrees')
                                    ->multiple()
                                    ->required()
                                    ->native(false),

                                Forms\Components\Select::make('streams')
                                    ->options(Stream::all()->pluck('label', 'id')->toArray())
                                    ->label('Streams')
                                    ->multiple()
                                    ->required()
                                    ->native(false),

                                Forms\Components\TextInput::make('percentage')
                                    ->required()
                                    ->suffix('%')
                                    ->numeric()
                                    ->placeholder('e.g. 10, 30, 60'),
                            ])
                            ->columns(3),

                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\TextInput::make('backlogs')
                                    ->required()
                                    ->numeric()
                                    ->placeholder('e.g. 5, 12'),

                                Forms\Components\TextInput::make('study_gap')
                                    ->suffix('Months')
                                    ->label('Study Gap')
                                    ->placeholder('e.g. 1, 3')
                                    ->required()
                                    ->numeric(),
                            ])
                            ->columns(2),

                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Select::make('exam')
                                    ->required()
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
                                    ->required()
                                    ->numeric(),

                                Forms\Components\TextInput::make('speaking')
                                    ->required()
                                    ->numeric(),

                                Forms\Components\TextInput::make('reading')
                                    ->required()
                                    ->numeric(),

                                Forms\Components\TextInput::make('writing')
                                    ->required()
                                    ->numeric(),
                            ])
                            ->columns(5), // Display in five columns
                    ])
            ])
            ->statePath('data');
    } 

    protected function getFormActions(): array
    {
        return [
            Action::make('search')
                ->label('Search')
                ->submit('search'),
        ];
    }

    public function search() 
    {
        $data = $this->form->getState();

        $streams = '[' . implode("', '", $data['streams']) . "']";
        $degrees = '[' . implode("', '", $data['degrees']) . "']";

        $url = "/user/programs?" .
            "tableFilters[all][backlogs]={$data['backlogs']}&" .
            "tableFilters[all][study_gap]={$data['study_gap']}&" .
            "tableFilters[all][exam]={$data['exam']}&" .
            "tableFilters[all][listening]={$data['listening']}&" .
            "tableFilters[all][speaking]={$data['speaking']}&" .
            "tableFilters[all][reading]={$data['reading']}&" .
            "tableFilters[all][writing]={$data['writing']}&" .
            "tableFilters[all][percentage]={$data['percentage']}&" .
            "tableFilters[all][streams]={$streams}&" .
            "tableFilters[all][degrees]={$degrees}";

        $searchLogData = $data;
        $searchLogData['user_id'] = auth()->id();

        SearchLog::create($searchLogData);
        
        return redirect($url);
    }
}
