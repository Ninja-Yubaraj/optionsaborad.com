<?php

namespace App\Filament\User\Widgets;

use Filament\Widgets\Widget;

class Cards extends Widget
{
    protected static string $view = 'filament.user.widgets.cards';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 200;
}
