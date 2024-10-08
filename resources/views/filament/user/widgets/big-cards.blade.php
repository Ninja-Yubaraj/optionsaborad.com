<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            <x-filament::icon
                alias="panels::topbar.global-search.field"
                icon="heroicon-m-credit-card"
                wire:target="search"
                class="h-10 w-10 text-gray-500 dark:text-gray-400"
            />

            <div class="flex-1">
                <h2
                    class="grid flex-1 text-base font-semibold leading-6 text-gray-950 dark:text-white"
                >
                    {{ 'Student Visa' }}
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Streamlined Visitor Visa Application Process
                </p>
            </div>

            <form
                action= "{{'#'}}" 
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
                    Search
                </x-filament::button>
            </form>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

