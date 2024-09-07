<?php
    use Filament\Facades\Filament;

    $logo = 'images/aboard.png';
    $height = '70px';

    if (auth()->check()) {
        try {
            $panel = Filament::getCurrentPanel();

            if ($panel->getId() == 'user') {
                $logo = auth()->user()->getLogo();
                $height = '60px';
            }
        } catch (\Exception $e) {
            $logo = 'images/aboard.png';
            $height = '70px';
        }
    } else {
        $height = '150px';
    }
?>
<div class="flex items-center">
    <img 
        style="width: auto; height: {{$height}};" 
        src="{{ asset($logo) }}" 
        alt="{{ env("APP_NAME") }}"
    />
</div>
