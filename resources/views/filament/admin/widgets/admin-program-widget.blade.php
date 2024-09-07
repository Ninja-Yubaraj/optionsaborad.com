<x-filament-widgets::widget>
    @php

        $programsCount = App\Models\Program::count();

    @endphp
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            <x-filament::icon
                alias="panels::topbar.global-search.field"
                icon="heroicon-m-rectangle-stack"
                wire:target="search"
                class="h-10 w-10 text-gray-500 dark:text-gray-400"
            />

            <div class="flex-1">
                <h2
                    class="grid flex-1 text-base font-semibold leading-6 text-gray-950 dark:text-white"
                >
                    {{ 'Programs (' . $programsCount . ')' }}
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Manage Programs in Yukon Overseas
                </p>
            </div>

            <form
                action= "{{'/admin/programs'}}" 
                method="get"
                class="my-auto"
            >
                @csrf

                <x-filament::button
                    color="gray"
                    icon="heroicon-m-chevron-right"
                    icon-alias="panels::widgets.account.logout-button"
                    labeled-from="sm"
                    tag="button"
                    type="submit"
                >
                    Manage
                </x-filament::button>
            </form>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
