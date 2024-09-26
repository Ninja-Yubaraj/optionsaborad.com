<x-filament-widgets::widget>
    <style>
      @media (min-width: 768px) {
        /* Additional styling for medium-sized screens (laptops) */
        .cards-width {
            min-width: 505px; 
            max-width: 705px;
        }
    }

    @media (max-width: 768px) {
        /* Additional styling for small screens (mobile) */
        .cards-width {
            min-width: 400px; 
            max-width: 400px;
        }
    }
    </style>
    
    <!-- First Row -->
    <div class="flex flex-wrap gap-4">
        <!-- First Card: Student Visa -->
        <a href="#" class="flex flex-col">
            <x-filament::section class="cards-width">
                <div class="flex items-center gap-x-3">
                    <x-filament::icon
                        alias="panels::topbar.global-search.field"
                        icon="heroicon-m-credit-card"
                        wire:target="search"
                        class="h-10 w-10 text-gray-500 dark:text-gray-400"
                    />

                    <div class="flex-1">
                        <h2 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                            {{ 'Student Visa' }}
                        </h2>

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Streamlined Visitor Visa Application Process
                        </p>
                    </div>
                </div>
            </x-filament::section>
        </a>

        <!-- Second Card: Dependent Visa -->
        <a href="#" class="flex flex-col">
            <x-filament::section class="cards-width">
                <div class="flex items-center gap-x-3">
                    <x-filament::icon
                        alias="panels::topbar.global-search.field"
                        icon="heroicon-m-window"
                        wire:target="search"
                        class="h-10 w-10 text-gray-500 dark:text-gray-400"
                    />

                    <div class="flex-1">
                        <h2 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                            {{ 'Dependent Visa' }}
                        </h2>

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Seamless Dependent Visa Sponsorship Support
                        </p>
                    </div>
                </div>
            </x-filament::section>
        </a>

        <!-- Third Card: MBBS -->
        <a href="#" class="flex flex-col">
            <x-filament::section class="cards-width">
                <div class="flex items-center gap-x-3">
                    <x-filament::icon
                        alias="panels::topbar.global-search.field"
                        icon="heroicon-m-book-open"
                        wire:target="search"
                        class="h-10 w-10 text-gray-500 dark:text-gray-400"
                    />

                    <div class="flex-1">
                        <h2 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                            {{ 'MBBS' }}
                        </h2>

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Bachelor of Medicine and Surgery: Medical Education
                        </p>
                    </div>
                </div>
            </x-filament::section>
        </a>

        <!-- Fourth Card: SOP / Justification Writing -->
        <a href="#" class="flex flex-col">
            <x-filament::section class="cards-width">
                <div class="flex items-center gap-x-3">
                    <x-filament::icon
                        alias="panels::topbar.global-search.field"
                        icon="heroicon-m-pencil-square"
                        wire:target="search"
                        class="h-10 w-10 text-gray-500 dark:text-gray-400"
                    />

                    <div class="flex-1">
                        <h2 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                            {{ 'SOP / Justification Writing' }}
                        </h2>

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Expert SOP and Justification Crafting
                        </p>
                    </div>
                </div>
            </x-filament::section>
        </a>

        <!-- Fifth Card: Education Loan -->
        <a href="#" class="flex flex-col">
            <x-filament::section class="cards-width">
                <div class="flex items-center gap-x-3">
                    <x-filament::icon
                        alias="panels::topbar.global-search.field"
                        icon="heroicon-m-academic-cap"
                        wire:target="search"
                        class="h-10 w-10 text-gray-500 dark:text-gray-400"
                    />

                    <div class="flex-1">
                        <h2 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                            {{ 'Education Loan' }}
                        </h2>

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Flexible Education Financing Solutions
                        </p>
                    </div>
                </div>
            </x-filament::section>
        </a>

        <!-- Sixth Card: Forex Service -->
        <a href="#" class="flex flex-col">
            <x-filament::section class="cards-width">
                <div class="flex items-center gap-x-3">
                    <x-filament::icon
                        alias="panels::topbar.global-search.field"
                        icon="heroicon-m-presentation-chart-bar"
                        wire:target="search"
                        class="h-10 w-10 text-gray-500 dark:text-gray-400"
                    />

                    <div class="flex-1">
                        <h2 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                            {{ 'Forex Service' }}
                        </h2>

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Efficient Forex Exchange with Competitive Rates
                        </p>
                    </div>
                </div>
            </x-filament::section>
        </a>

        <!-- Seventh Card: Coaching Material -->
        <a href="#" class="flex flex-col">
            <x-filament::section class="cards-width">
                <div class="flex items-center gap-x-3">
                    <x-filament::icon
                        alias="panels::topbar.global-search.field"
                        icon="heroicon-m-sparkles"
                        wire:target="search"
                        class="h-10 w-10 text-gray-500 dark:text-gray-400"
                    />

                    <div class="flex-1">
                        <h2 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                            {{ 'Coaching Material' }}
                        </h2>

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Rich Coaching Material for Enhanced Learning
                        </p>
                    </div>
                </div>
            </x-filament::section>
        </a>

        <!-- Eighth Card: Language Coaching -->
        <a href="#" class="flex flex-col">
            <x-filament::section class="cards-width">
                <div class="flex items-center gap-x-3">
                    <x-filament::icon
                        alias="panels::topbar.global-search.field"
                        icon="heroicon-m-language"
                        wire:target="search"
                        class="h-10 w-10 text-gray-500 dark:text-gray-400"
                    />

                    <div class="flex-1">
                        <h2 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                            {{ 'Language Coaching' }}
                        </h2>

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Language Coaching Services for Improved Communication
                        </p>
                    </div>
                </div>
            </x-filament::section>
        </a>
    </div>
</x-filament-widgets::widget>
