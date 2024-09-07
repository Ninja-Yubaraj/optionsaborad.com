<?php

namespace App\Filament\Admin\Widgets;

use App\Models\ForexRate;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class TotalStats extends BaseWidget
{
    public function getColumns(): int
    {
        return 3;    
    }

    protected static ?int $sort = 300;

    protected function getStats(): array
    {
        $dataEntries = User::where('role', 'data')->get();
        $clientUsers = User::where('role', '!=', 'data')->where('role', '!=', 'admin')->get();
        $forexRates = ForexRate::all();

        return [
            Stat::make('Total Data Entries', $dataEntries->count())
                ->icon('heroicon-m-users')
                ->url('/admin/data-entries'),

            Stat::make('Total Client Users', $clientUsers->count())
                ->icon('heroicon-m-user-group')
                ->url('/admin/users'),

            Stat::make('Total Forex Rates', $forexRates->count())
                ->icon('heroicon-m-presentation-chart-line')
                ->url('/admin/forex-rates'),

        ];
    }
}
