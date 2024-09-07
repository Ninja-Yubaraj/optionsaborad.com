<x-filament::section class="hidden md:block floating-section">
    <style>
        @media (min-width: 768px) {
            /* Styling for medium-sized screens (laptops) */
            .fi-main {
                padding-right: 220px;
            }

            .floating-section {
                min-width: 200px;
                max-width: 250px;
                position: fixed !important;
                right: 0;
                margin-right: 20px;
                margin-top: 80px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            }

            
            .floating-section h3 {
                font-size: 18px;
                font-weight: bold;
                color: #333;
                margin-bottom: 10px;
                text-transform: uppercase;
                border-bottom: 2px solid #ccc;
                padding-bottom: 5px;
                text-align: center;
            }

            .floating-section .p-6 {
                padding: 0.5rem;
            }

            .rate {
                color: #009900;
                font-weight: bold;
            }

        }
    </style>

    @php
    $forexRates = App\Models\ForexRate::all();
    @endphp
    <div>
        <h3>Forex Rates</h3>
    </div>
    <div>
        <ul>
            @foreach ($forexRates as $forexRate)
                <li style="margin-bottom: 5px; margin-left: 7px">{{$forexRate->from}}-{{$forexRate->to}} <span class="rate">{{number_format($forexRate->rate, 2)}}</span></li>
            @endforeach
        </ul>
    </div>
</x-filament::section>

<x-filament::section class="hidden md:block floating-section" style="bottom: 0 !important; padding: 1px; margin-bottom: 20px !important; max-width: 200px !important;">
    <ul style="margin: 0; padding: 0;">
        <li style="margin: 0; padding: 0; margin-bottom: 5px; margin-left: 7px; font-size: 15px;">
            For technical <br/> queries contact
            <a href="tel:+918780082392" style="display: inline-block; white-space: nowrap;">
                <span style="color: #04cae0; font-weight: bold;">+918780082392</span>
            </a>
        </li>
        <li style="margin: 0; padding: 0; margin-bottom: 5px; margin-left: 7px; font-size: 14px;">
            For Program related queries contact
            <a href="tel:+918780082392" style="display: inline-block; white-space: nowrap;">
                <span style="color: #04cae0; font-weight: bold;">+917600958750</span>
            </a>
        </li>
    </ul>
</x-filament::section>