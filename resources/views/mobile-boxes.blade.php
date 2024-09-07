<x-filament::section class="block md:hidden floating-section">
    <style>
        @media (max-width: 768px) {
            .floating-section {
                min-width: 200px;
                max-width: 250px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                margin-bottom: 10px;
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