<div>
    <div class="flex justify-around px-8 py-4 gap-4">
        <a
            href="#"
            class="relative w-full block rounded-sm border-t-4 border-pink-600 p-1 pl-4 shadow-xl"
        >
            <div class="flex items-center gap-1">
                <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 text-pink-600 sm:h-8 sm:w-8"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z"
                    />
                </svg>
                <h3 class="text-3xl font-bold">
                    @if ($by == 'm')
                        {{ number_format($this->total_mol_pnl() / 1e+6, 2) }}M
                    @elseif ($by == 't')
                        {{ number_format($this->total_mol_pnl() / 1e+3, 2) }}K
                    @else
                        {{ number_format($this->total_mol_pnl(), 2) }}
                    @endif
                </h3>
            </div>

            <p class="mt-4 font-medium text-gray-500">
                5 Year Revenue
            </p>
        </a>

        <a
            href="#"
            class="relative w-full block rounded-sm border-t-4 border-yellow-600 p-1 pl-4 shadow-xl"
        >
            <div class="flex items-center gap-1">
                <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 text-yellow-600 sm:h-8 sm:w-8"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z"
                    />
                </svg>

                <h3 class="text-3xl font-bold">
                    @if ($by == 'm')
                        {{ number_format(($this->gross_profit_total() - $this->get_operating_total()) / 1e+6, 2) }}M
                    @elseif ($by == 't')
                        {{ number_format(($this->gross_profit_total() - $this->get_operating_total()) / 1e+3, 2) }}K
                    @else
                        {{ number_format(($this->gross_profit_total() - $this->get_operating_total()), 2) }}
                    @endif
                </h3>
            </div>

            <p class="mt-4 font-medium text-gray-500">
                PBT
            </p>
        </a>

        <a
            href="#"
            class="relative w-full block rounded-sm border-t-4 border-purple-600 p-1 pl-4 shadow-xl"
        >
            <div class="flex items-center gap-1">
                <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 text-purple-600 sm:h-8 sm:w-8"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z"
                    />
                </svg>

                <h3 class="text-3xl font-bold">
                    <select>
                        <option>High</option>
                        <option>Medium</option>
                        <option>Low</option>
                    </select>
                </h3>
            </div>

            <p class="mt-4 font-medium text-gray-500">
                Category
            </p>
        </a>

        <a
            href="#"
            class="relative w-full block rounded-sm border-t-4 border-orange-600 p-1 pl-4 shadow-xl"
        >
            <div class="flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-orange-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                <h3 class="text-3xl font-bold">
                    {{ \Carbon\Carbon::parse($project->productMetric->launch_date)->format('M Y') }}
                </h3>
            </div>

            <p class="mt-4 font-medium text-gray-500">
                Launch Date
            </p>
        </a>
</div>

<hr>
<div class="p-8 max-w-6xl flex flex-col gap-2" x-data="{ by: @entangle('by'), future_matrix: @entangle('future_matrix'), matrix: @entangle('matrix'), extra_info: @entangle('extra_info'), operatings: @entangle('operatings'), spu_growth_matrix: @entangle('spu_growth_matrix'), loss: @entangle('loss'), cogs: @entangle('cogs'), actuals: @entangle('actuals')}" >
    <div class="flex items-center">
        <label for="by" class="mx-2 font-medium text-gray-700">By</label>
        <select name="by" id="by" wire:model="by" class="mx-2 rounded-md bg-gray-100 text-gray-700 py-2 px-4">
            <option value="m">Millions</option>
            <option value="t">Thousands</option>
            <option value="a">Absolutes</option>
        </select>
    </div>
    <section class="lock-div">
        <h2 class="text-lg font-bold">Market Dynamics</h2>
        <table x-data="{
            master_display: false, ga_display: false, mv_display: false, ms_display: false,
            get pre_display() {return this.master_display || this.ga_display || this.mv_display || this.ms_display;}
        }" class="text-sm text-right"
        >
            <thead>
                <th style="padding-right:0; padding-left:1em;" class="whitespace-nowrap flex justify-between items-center">
                    Years
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block"
                        @click="if (!master_display) { master_display = true; ga_display = true; mv_display = true; ms_display = true; } else { master_display = false; ga_display = false; mv_display = false; ms_display = false; }"
                        :class="{'rotate-180': master_display}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </th>
                @foreach ($project->yearsTillLaunch() as $year)
                    <th x-cloak x-show="pre_display">{{ date('Y', strtotime($year)) }}</th>
                @endforeach
                @foreach ($project->xMonthsFromLaunch() as $year)
                    @if (date('Y', strtotime($year)) == date('Y', strtotime($project->productMetric->launch_date)))
                        <th style="background-color:rgb(233 213 255);color:#222">{{ date('Y', strtotime($year)) }}</th>
                    @else
                        <th>{{ date('Y', strtotime($year)) }}</th>
                    @endif
                @endforeach
            </thead>
            <tbody>
                <tr class="bg-green-300">
                    <th class="whitespace-nowrap flex justify-between items-center">
                        {{ __('Growth Assumptions') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block"
                            :class="{'rotate-180': ga_display}" @click="ga_display = !ga_display">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </th>
                    <td colspan="{{ $project->years->count() + $project->extra_years->count() + 1 }}"></td>
                </tr>
                @foreach ($project->marketMetric->strengths as $strength)
                    <tr x-cloak x-show="ga_display"
                        x-transition:enter="transition ease-out duration-{{ $loop->iteration * 100 }}"
                        x-transition:enter-start="opacity-0 transform scale-90"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-{{ $loop->remaining * 100 }}"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-90"
                    >
                        <th>{{ $strength->name }}</th>
                        @foreach ($project->years as $year)
                            <td x-cloak x-show="pre_display">
                                {{ $this->calculate_perc($year, $strength->name, $reevaluate) }}
                            </td>
                        @endforeach
                        @foreach ($project->extra_years as $year)
                            <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                                x-data="{editing:false}">
                                <input x-cloak x-ref="input" wire:model="future_matrix.{{ $strength->name }}.{{ $year }}.0" x-show="editing" class="w-full" type="text"
                                    />
                                <span x-show="!editing" x-cloak
                                    class="bg-yellow-100 w-full block"
                                    :class="{
                                        'bg-gray-200': future_matrix['{{ $strength->name }}']['{{ $year }}'][2] && future_matrix['{{ $strength->name }}']['{{ $year }}'][1] == future_matrix['{{ $strength->name }}']['{{ $year }}'][0],
                                        'bg-red-200': future_matrix['{{ $strength->name }}']['{{ $year }}'][1] != future_matrix['{{ $strength->name }}']['{{ $year }}'][0]
                                    }"
                                    >
                                    {{ $future_matrix[$strength->name][$year][0] }}%
                                </span>
                            </td>
                        @endforeach
                    </tr>
                @endforeach


                <tr class="bg-green-300">
                    <th class="whitespace-nowrap flex justify-between items-center">
                        {{ __('Market Volumes') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block"
                            :class="{'rotate-180': mv_display}" @click="mv_display = !mv_display">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </th>
                    <td x-cloak x-show="pre_display" colspan="{{ $project->yearsTillLaunch()->count() }}"></td>
                    @foreach($project->xMonthsFromLaunch() as $year)
                        <td>
                            @if ($by == 'm')
                                {{ number_format($this->total_vol_for($year) / 1.0e+6, 2) }}M
                            @elseif ($by == 't')
                                {{ number_format($this->total_vol_for($year) / 1.0e+3, 2) }}K
                            @else
                                {{ number_format($this->total_vol_for($year), 2) }}
                            @endif
                        </td>
                    @endforeach
                </tr>
                @foreach ($project->marketMetric->strengths as $strength)
                    <tr x-cloak x-show="mv_display"
                        x-transition:enter="transition ease-out duration-{{ $loop->iteration * 100 }}"
                        x-transition:enter-start="opacity-0 transform scale-90"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-{{ $loop->remaining * 100 }}"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-90"
                    >
                        <th>{{ $strength->name }}</td>
                        @foreach ($project->years as $year)
                            <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                                x-data="{editing:false}">
                                <input x-cloak x-ref="input" wire:model="matrix.{{ $strength->name }}.{{ $year }}.0" x-show="editing" class="w-full" type="text"
                                    />
                                <span x-show="!editing" x-cloak
                                    class="bg-yellow-100 w-full block"
                                    :class="{
                                        'bg-gray-200': matrix['{{ $strength->name }}']['{{ $year }}'][2] && matrix['{{ $strength->name }}']['{{ $year }}'][1] == matrix['{{ $strength->name }}']['{{ $year }}'][0],
                                        'bg-red-200': matrix['{{ $strength->name }}']['{{ $year }}'][1] != matrix['{{ $strength->name }}']['{{ $year }}'][0]
                                    }"
                                    >
                                    @if ($by == 'm')
                                        {{ number_format($matrix[$strength->name][$year][0] / 1.0e+6, 2) }}M
                                    @elseif ($by == 't')
                                        {{ number_format($matrix[$strength->name][$year][0] / 1.0e+3, 2) }}K
                                    @else
                                        {{ number_format($matrix[$strength->name][$year][0], 2) }}
                                    @endif
                                </span>
                            </td>
                        @endforeach
                        @foreach ($project->extra_years as $year)
                            <td>
                                <span>
                                    @if ($by == 'm')
                                        {{ number_format($this->calculate_vol($year, $strength->name, $reevaluate) / 1.0e+6, 2) }}M
                                    @elseif ($by == 't')
                                        {{ number_format($this->calculate_vol($year, $strength->name, $reevaluate) / 1.0e+3, 2) }}K
                                    @else
                                        {{ number_format($this->calculate_vol($year, $strength->name, $reevaluate), 2) }}
                                    @endif
                                </span>
                            </td>
                        @endforeach
                    </tr>
                @endforeach

                <tr class="bg-green-300">
                    <th class="whitespace-nowrap flex justify-between items-center">
                        {{ __('Market Sales') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block"
                            :class="{'rotate-180': ms_display}" @click="ms_display = !ms_display">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </th>
                    <td colspan="{{ $project->years->count() + $project->extra_years->count() + 1 }}"></td>
                </tr>
                @foreach ($project->marketMetric->strengths as $strength)
                    <tr x-cloak x-show="ms_display"
                        x-transition:enter="transition ease-out duration-{{ $loop->iteration * 100 }}"
                        x-transition:enter-start="opacity-0 transform scale-90"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-{{ $loop->remaining * 100 }}"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-90"
                    >
                        <th>{{ $strength->name }}</td>
                        @foreach ($project->years as $year)
                            <td>
                                @if ($by == 'm')
                                    {{ number_format($strength->get_sales($year) / 1.0e+6, 2) }}M
                                @elseif ($by == 't')
                                    {{ number_format($strength->get_sales($year) / 1.0e+3, 2) }}K
                                @else
                                    {{ number_format($strength->get_sales($year), 2) }}
                                @endif
                            </td>
                        @endforeach
                        @foreach ($project->extra_years as $year)
                            <td class="text-center">-</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <section class="lock-div">
        <h2 class="text-lg font-bold">Assumptions and Calculations</h2>
        <table class="text-sm text-right" x-data="{
            master_display: false, fv_display: false, su_display: false, cu_display: false,
        }">
            <thead>
                <th style="padding-right:0; padding-left:1em;" class="whitespace-nowrap flex justify-between items-center">
                    Years
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block"
                        @click="if (!master_display) { master_display = true; fv_display = true; su_display = true; cu_display = true; } else { master_display = false; fv_display = false; su_display = false; cu_display = false; }"
                        :class="{'rotate-180': master_display}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </th>
                <th colspan="4"></th>
                @foreach ($project->xMonthsFromLaunch() as $year)
                    @if (date('Y', strtotime($year)) == date('Y', strtotime($project->productMetric->launch_date)))
                        <th style="background-color:rgb(233 213 255);color:#222">{{ date('Y', strtotime($year)) }}</th>
                    @else
                        <th>{{ date('Y', strtotime($year)) }}</th>
                    @endif
                @endforeach
            </thead>
            <tbody>
                <tr>
                    <th>Expected Competitors</th>
                    <td colspan="4"></td>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                            x-data="{editing:false}">
                            <input x-cloak x-ref="input" wire:model="extra_info.{{ $year }}.expected_competitors.0"
                                x-show="editing" class="w-full" type="text"/>
                            <span x-show="!editing" x-cloak
                                class="bg-yellow-100 w-full block"
                                :class="{
                                    'bg-gray-200': extra_info['{{ $year }}']['expected_competitors'][1] == extra_info['{{ $year }}']['expected_competitors'][0],
                                    'bg-red-200': extra_info['{{ $year }}']['expected_competitors'][1] != extra_info['{{ $year }}']['expected_competitors'][0]
                                }"
                            >
                                {{ $extra_info[$year]['expected_competitors'][0] }}
                            </span>
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <th>Order of Entry</th>
                    <td colspan="4"></td>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                            x-data="{editing:false}">
                            <input x-cloak x-ref="input" wire:model="extra_info.{{ $year }}.order_of_entry.0"
                                x-show="editing" class="w-full" type="text"/>
                            <span x-show="!editing" x-cloak
                                class="bg-yellow-100 w-full block"
                                :class="{
                                    'bg-gray-200': extra_info['{{ $year }}']['order_of_entry'][1] == extra_info['{{ $year }}']['order_of_entry'][0],
                                    'bg-red-200': extra_info['{{ $year }}']['order_of_entry'][1] != extra_info['{{ $year }}']['order_of_entry'][0]
                                }"
                            >
                                {{ $extra_info[$year]['order_of_entry'][0] }}
                            </span>
                        </td>
                    @endforeach
                </tr>


                <tr>
                    <th>Sales Months</th>
                    <td colspan="4"></td>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td>
                            {{ $extra_info[$year]['sales_months'] }}
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <th>Market Share</th>
                    <td colspan="4"></td>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td>
                            {{ $this->get_market_share($year) . '%' }}
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <th>Effective Market Share</th>
                    <td colspan="4"></td>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td>
                            {{ $this->get_effective_market_share($year) . '%' }}
                        </td>
                    @endforeach
                </tr>

                <th class="whitespace-nowrap flex justify-between items-center">
                    {{ __('Forecasted Volume') }}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block"
                        :class="{'rotate-180': fv_display}" @click="fv_display = !fv_display">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                    <td class="bg-green-300" colspan="100%"></td>
                </th>

                @foreach($project->marketMetric->strengths as $strength)
                    <tr
                        x-cloak x-show="fv_display"
                        x-transition:enter="transition ease-out duration-{{ $loop->iteration * 100 }}"
                        x-transition:enter-start="opacity-0 transform scale-90"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-{{ $loop->remaining * 100 }}"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-90"
                    >
                        <th>{{ $strength->name }}</th>
                        <td colspan="4"></td>
                        @foreach ($project->xMonthsFromLaunch() as $year)
                            <td>
                                {{ $this->get_market_size($strength->name, $year) }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach

                <tr>
                    <th>BWAC</th>
                    <td colspan="4"></td>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td>
                            {{ $this->get_bwac($year) . '%' }}
                        </td>
                    @endforeach
                </tr>

                <tr class="bg-green-300">
                    <th class="whitespace-nowrap flex justify-between items-center">
                        {{ __('Selling Price / Unit') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block"
                            :class="{'rotate-180': su_display}" @click="su_display = !su_display">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </th>
                    <td>Current</td>
                    <td x-cloak class="whitespace-nowrap">Growth Percent</td>
                    <td>Loe</td>
                    <td title="Price Change" x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                        x-data="{editing:false}">
                        <input x-cloak x-ref="input" wire:model="loss.0" class="w-full"
                            x-show="editing" type="text"/>
                        <span x-show="!editing" x-cloak
                            class="bg-yellow-100 w-full block"
                            :class="{
                                'bg-gray-200': loss[1] == loss[0],
                                'bg-red-200': loss[1] != loss[0]
                            }"
                        >
                            {{ $loss[0] . '%' }}
                        </span>
                    </td>
                    <td colspan="100%"></td>
                </tr>

                @foreach($project->marketMetric->strengths as $strength)
                    <tr x-cloak x-show="su_display"
                        x-transition:enter="transition ease-out duration-{{ $loop->iteration * 100 }}"
                        x-transition:enter-start="opacity-0 transform scale-90"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-{{ $loop->remaining * 100 }}"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-90"
                    >
                        <th>{{ $strength->name }}</th>
                        <td>
                            {{
                                number_format(
                                    $current_matrix[$strength->name]
                                , 2)
                            }}
                        </td>
                        <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                            x-data="{editing:false}">
                            <input x-cloak x-ref="input" wire:model="spu_growth_matrix.{{ $strength->name }}.0"
                                x-show="editing" type="text"/>
                            <span x-show="!editing" x-cloak
                                class="bg-yellow-100 w-full block"
                                :class="{
                                    'bg-gray-200': spu_growth_matrix['{{ $strength->name }}'][1] == spu_growth_matrix['{{ $strength->name }}'][0],
                                    'bg-red-200': spu_growth_matrix['{{ $strength->name }}'][1] != spu_growth_matrix['{{ $strength->name }}'][0]
                                }"
                            >
                                {{ $spu_growth_matrix[$strength->name][0] }}
                            </span>
                        </td>
                        <td>
                            {{  number_format (
                                $current_matrix[$strength->name]
                                * (1 + ($spu_growth_matrix[$strength->name][0] / 100)) ** $project->xMonthsFromLaunch()->count()
                                , 2)
                            }}
                        </td>
                        <td>
                            {{ $loss[0] . '%' }}
                        </td>
                        @foreach ($project->xMonthsFromLaunch() as $year)
                            <td>
                                {{ number_format($spu_values[$strength->name][$year], 2) }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach

                <tr class="bg-green-300">
                    <th class="whitespace-nowrap flex justify-between items-center">
                        {{ __('COGS / Unit') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block"
                            :class="{'rotate-180': cu_display}" @click="cu_display = !cu_display">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </th>
                    <td colspan="2"></td>
                    <td>Actuals</td>
                    <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                        x-data="{editing:false}">
                        <input x-cloak x-ref="input" wire:model="cogs.0" class="w-full"
                            x-show="editing" type="text"/>
                        <span x-show="!editing" x-cloak
                            class="bg-yellow-100 w-full block"
                            :class="{
                                'bg-gray-200': cogs[1] == cogs[0],
                                'bg-red-200': cogs[1] != cogs[0]
                            }"
                        >
                            {{ $cogs[0] . '%' }}
                        </span>
                    </td>
                </tr>
                @foreach($project->marketMetric->strengths as $strength)
                    <tr x-cloak x-show="cu_display"
                        x-transition:enter="transition ease-out duration-{{ $loop->iteration * 100 }}"
                        x-transition:enter-start="opacity-0 transform scale-90"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-{{ $loop->remaining * 100 }}"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-90"
                    >
                        <th>{{ $strength->name }}</th>
                        <td colspan="2"></td>
                        <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                            x-data="{editing:false}">
                            <input x-cloak x-ref="input" wire:model="actuals.{{ $strength->name }}.0"
                                x-show="editing" type="text"/>
                            <span x-show="!editing" x-cloak
                                class="bg-yellow-100 w-full block"
                                :class="{
                                    'bg-gray-200': actuals['{{ $strength->name }}'][1] == actuals['{{ $strength->name }}'][0],
                                    'bg-red-200': actuals['{{ $strength->name }}'][1] != actuals['{{ $strength->name }}'][0]
                                }"
                            >
                                {{ number_format($actuals[$strength->name][0], 2) }}
                            </span>
                        </td>
                        <td class="border w-20 border-gray-800">
                            {{ $cogs[0] . '%' }}
                        </td>
                        @foreach ($project->xMonthsFromLaunch() as $year)
                            <td class="border w-20 border-gray-800">
                                {{ number_format($this->calculate_cogs_units($strength->name, $year), 2) }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach

            </tbody>
        </table>
    </section>

    <section class="lock-div">
        <h2 class="text-lg font-bold">Molecule P/L</h2>
        <table x-data="{
            master_display: false, pl_display: false, cogs_display: false, oc_display: false, info_display: false, su_display: false, cu_display: false,
        }" class="text-sm text-right"
        >
            <thead>
                <th style="padding-right:0; padding-left:1em;" class="whitespace-nowrap flex justify-between items-center">
                    Years
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block"
                        @click="if (!master_display) { master_display = true; pl_display = true; cogs_display = true; oc_display = true; info_display = true; su_display = true; cu_display = true; } else { master_display = false; pl_display = false; cogs_display = false; oc_display = false; info_display = false; su_display = false; cu_display = false; }"
                        :class="{'rotate-180': master_display}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </th>
                @foreach ($project->xMonthsFromLaunch() as $year)
                    @if (date('Y', strtotime($year)) == date('Y', strtotime($project->productMetric->launch_date)))
                        <th style="background-color:rgb(233 213 255);color:#222">{{ date('Y', strtotime($year)) }}</th>
                    @else
                        <th>{{ date('Y', strtotime($year)) }}</th>
                    @endif
                @endforeach
                <th>Total</th>
            </thead>
            <tbody>
                <tr class="bg-green-300">
                    <th class="whitespace-nowrap flex justify-between items-center">
                        {{ __('Est. Sales') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block"
                            :class="{'rotate-180': pl_display}" @click="pl_display = !pl_display">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </th>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td>
                            @if ($by == 'm')
                                {{ number_format($this->total_mol_pnl_by_year($year) / 1e+6, 2) }}M
                            @elseif ($by == 't')
                                {{ number_format($this->total_mol_pnl_by_year($year) / 1e+3, 2) }}K
                            @else
                                {{ number_format($this->total_mol_pnl_by_year($year), 2) }}
                            @endif
                        </td>
                    @endforeach
                    <td>
                        @if ($by == 'm')
                            {{ number_format($this->total_mol_pnl() / 1e+6, 2) }}M
                        @elseif ($by == 't')
                            {{ number_format($this->total_mol_pnl() / 1e+3, 2) }}K
                        @else
                            {{ number_format($this->total_mol_pnl(), 2) }}
                        @endif
                    </td>
                </tr>
                @foreach($project->marketMetric->strengths as $strength)
                    <tr x-cloak x-show="pl_display"
                        x-transition:enter="transition ease-out duration-{{ $loop->iteration * 100 }}"
                        x-transition:enter-start="opacity-0 transform scale-90"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-{{ $loop->remaining * 100 }}"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-90"
                    >
                        <th class="whitespace-nowrap">{{ $strength->name }}</th>
                        @foreach ($project->xMonthsFromLaunch() as $year)
                            <td>
                                @if ($by == 'm')
                                    {{ number_format($this->calculate_mol_pnl($strength->name, $year) / 1e+6, 2) }}M
                                @elseif ($by == 't')
                                    {{ number_format($this->calculate_mol_pnl($strength->name, $year) / 1e+3, 2) }}K
                                @else
                                    {{ number_format($this->calculate_mol_pnl($strength->name, $year), 2) }}
                                @endif
                            </td>
                        @endforeach
                        <td>
                            @if ($by == 'm')
                                {{ number_format($this->total_mol_pnl_by_strength($strength->name) / 1e+6, 2) }}M
                            @elseif ($by == 't')
                                {{ number_format($this->total_mol_pnl_by_strength($strength->name) / 1e+3, 2) }}K
                            @else
                                {{ number_format($this->total_mol_pnl_by_strength($strength->name), 2) }}
                            @endif
                        </td>
                    </tr>
                @endforeach

                <tr class="bg-green-300">
                    <th class="whitespace-nowrap flex justify-between items-center">
                        {{ __('COGS') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block"
                            :class="{'rotate-180': cogs_display}" @click="cogs_display = !cogs_display">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </th>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td>
                            @if ($by == 'm')
                                {{ number_format($this->total_cogs_by_year($year) / 1e+6, 2) }}M
                            @elseif ($by == 't')
                                {{ number_format($this->total_cogs_by_year($year) / 1e+3, 2) }}K
                            @else
                                {{ number_format($this->total_cogs_by_year($year), 2) }}
                            @endif
                        </td>
                    @endforeach
                    <td>
                        @if ($by == 'm')
                            {{ number_format($this->total_cogs() / 1e+6, 2) }}M
                        @elseif ($by == 't')
                            {{ number_format($this->total_cogs() / 1e+3, 2) }}K
                        @else
                            {{ number_format($this->total_cogs(), 2) }}
                        @endif
                    </td>
                </tr>
                @foreach($project->marketMetric->strengths as $strength)
                    <tr x-cloak x-show="cogs_display"
                        x-transition:enter="transition ease-out duration-{{ $loop->iteration * 100 }}"
                        x-transition:enter-start="opacity-0 transform scale-90"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-{{ $loop->remaining * 100 }}"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-90"
                    >
                        <th class="whitespace-nowrap">{{ $strength->name }}</th>
                        @foreach ($project->xMonthsFromLaunch() as $year)
                            <td>
                                @if ($by == 'm')
                                    {{ number_format($this->calculate_cogs($strength->name, $year) / 1e+6, 2) }}M
                                @elseif ($by == 't')
                                    {{ number_format($this->calculate_cogs($strength->name, $year) / 1e+3, 2) }}K
                                @else
                                    {{ number_format($this->calculate_cogs($strength->name, $year), 2) }}
                                @endif
                            </td>
                        @endforeach
                        <td>
                            @if ($by == 'm')
                                {{ number_format($this->total_cogs_by_strength($strength->name) / 1e+6, 2) }}M
                            @elseif ($by == 't')
                                {{ number_format($this->total_cogs_by_strength($strength->name) / 1e+3, 2) }}K
                            @else
                                {{ number_format($this->total_cogs_by_strength($strength->name), 2) }}
                            @endif
                        </td>
                    </tr>
                @endforeach


                <tr class="bg-green-300">
                    <th>Gross Profit</th>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td>
                            @if ($by == 'm')
                                {{ number_format($this->gross_profit_by_year($year) / 1e+6, 2) }}M
                            @elseif ($by == 't')
                                {{ number_format($this->gross_profit_by_year($year) / 1e+3, 2) }}K
                            @else
                                {{ number_format($this->gross_profit_by_year($year), 2) }}
                            @endif
                        </td>
                    @endforeach
                    <td>
                        @if ($by == 'm')
                            {{ number_format($this->gross_profit_total() / 1e+6, 2) }}M
                        @elseif ($by == 't')
                            {{ number_format($this->gross_profit_total() / 1e+3, 2) }}K
                        @else
                            {{ number_format($this->gross_profit_total(), 2) }}
                        @endif
                    </td>
                </tr>
                <tr class="bg-green-300">
                    <th>Gross Profit %</th>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td>
                            {{ number_format($this->gross_profit_percent_by_year($year), 2) . '%' }}
                        </td>
                    @endforeach
                    <td>
                        {{ number_format($this->gross_profit_percent_total(), 2) . '%' }}
                    </td>
                </tr>

                <tr class="bg-green-300">
                    <th class="whitespace-nowrap flex justify-between items-center">
                        {{ __('Total Operating Costs') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block"
                            :class="{'rotate-180': oc_display}" @click="oc_display = !oc_display">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </th>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td class="border w-20 border-gray-800">
                            {{ $this->get_operating_cost_by_year($year) }}
                        </td>
                    @endforeach
                    <td class="border w-20 border-gray-800">
                        {{ $this->get_operating_total() }}
                    </td>
                </tr>
                <tr x-cloak x-show="oc_display"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-400"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90"
                >
                    <th>Development Cost</th>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                            x-data="{editing:false}">
                            <input class="w-full" x-cloak x-ref="input" wire:model="operatings.{{ $year }}.development_cost.0"
                                x-show="editing" type="text"/>
                            <span x-show="!editing" x-cloak
                                class="bg-yellow-100 w-full block"
                                :class="{
                                    'bg-gray-200': operatings['{{ $year }}']['development_cost'][1] == operatings['{{ $year }}']['development_cost'][0],
                                    'bg-red-200': operatings['{{ $year }}']['development_cost'][1] != operatings['{{ $year }}']['development_cost'][0]
                                }"
                            >
                                {{ $operatings[$year]['development_cost'][0] }}
                            </span>
                        </td>
                    @endforeach
                    <td>
                        {{ $this->get_operating_cost_by_type('development_cost') }}
                    </td>
                </tr>
                <tr x-cloak x-show="oc_display"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90"
                >
                    <th>Litigation Cost</th>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                            x-data="{editing:false}">
                            <input class="w-full" x-cloak x-ref="input" wire:model="operatings.{{ $year }}.litigation_cost.0"
                                x-show="editing" type="text"/>
                            <span x-show="!editing" x-cloak
                                class="bg-yellow-100 w-full block"
                                :class="{
                                    'bg-gray-200': operatings['{{ $year }}']['litigation_cost'][1] == operatings['{{ $year }}']['litigation_cost'][0],
                                    'bg-red-200': operatings['{{ $year }}']['litigation_cost'][1] != operatings['{{ $year }}']['litigation_cost'][0]
                                }"
                            >
                                {{ $operatings[$year]['litigation_cost'][0] }}
                            </span>
                        </td>
                    @endforeach
                    <td>
                        {{ $this->get_operating_cost_by_type('litigation_cost') }}
                    </td>
                </tr>
                <tr x-cloak x-show="oc_display"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90"
                >
                    <th>Other Costs</th>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                            x-data="{editing:false}">
                            <input x-cloak x-ref="input" wire:model="operatings.{{ $year }}.other_cost.0" class="w-full"
                                x-show="editing" class="w-full" type="text"/>
                            <span x-show="!editing" x-cloak
                                class="bg-yellow-100 w-full block"
                                :class="{
                                    'bg-gray-200': operatings['{{ $year }}']['other_cost'][1] == operatings['{{ $year }}']['other_cost'][0],
                                    'bg-red-200': operatings['{{ $year }}']['other_cost'][1] != operatings['{{ $year }}']['other_cost'][0]
                                }"
                            >
                                {{ $operatings[$year]['other_cost'][0] }}
                            </span>
                        </td>
                    @endforeach
                    <td>
                        {{ $this->get_operating_cost_by_type('other_cost') }}
                    </td>
                </tr>
                <tr class="bg-green-300">
                    <th class="whitespace-nowrap flex justify-between items-center">
                        {{ __('PBT') }}
                    </th>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td>
                            @if ($by == 'm')
                                {{ number_format(($this->gross_profit_by_year($year) - $this->get_operating_cost_by_year($year)) / 1e+6, 2) }}M
                            @elseif ($by == 't')
                                {{ number_format(($this->gross_profit_by_year($year) - $this->get_operating_cost_by_year($year)) / 1e+3, 2) }}K
                            @else
                                {{ number_format(($this->gross_profit_by_year($year) - $this->get_operating_cost_by_year($year)), 2) }}
                            @endif
                        </td>
                    @endforeach
                    <td>
                        @if ($by == 'm')
                            {{ number_format(($this->gross_profit_total($year) - $this->get_operating_total($year)) / 1e+6, 2) }}M
                        @elseif ($by == 't')
                            {{ number_format(($this->gross_profit_total($year) - $this->get_operating_total($year)) / 1e+3, 2) }}K
                        @else
                            {{ number_format(($this->gross_profit_total($year) - $this->get_operating_total($year)), 2) }}
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
</div>
</div>
