<div class="p-8" x-data="{ future_matrix: @entangle('future_matrix'), matrix: @entangle('matrix'), extra_info: @entangle('extra_info') }">
    <section class="lock-div">
        <table>
            <thead>
                <th>Years</th>
                @foreach ($project->years as $year)
                    <th>{{ date('Y', strtotime($year)) }}</th>
                @endforeach
                @foreach ($project->extra_years as $year)
                    @if (date('Y', strtotime($year)) == date('Y', strtotime($project->productMetric->launch_date)))
                        <th style="background-color:rgb(233 213 255);color:#222">{{ date('Y', strtotime($year)) }}</th>
                    @else
                        <th>{{ date('Y', strtotime($year)) }}</th>
                    @endif
                @endforeach
            </thead>
            <tbody>
                <tr>
                    <th>
                        {{ __('Growth Assumptions') }}
                    </th>
                    <td colspan="{{ $project->years->count() + $project->extra_years->count() }}"></td>
                </tr>
                @foreach ($project->marketMetric->strengths as $strength)
                    <tr>
                        <th>{{ $strength->name }}</th>
                        @foreach ($project->years as $year)
                            <td>
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
                                        'bg-green-200': future_matrix['{{ $strength->name }}']['{{ $year }}'][2] && future_matrix['{{ $strength->name }}']['{{ $year }}'][1] == future_matrix['{{ $strength->name }}']['{{ $year }}'][0],
                                        'bg-red-200': future_matrix['{{ $strength->name }}']['{{ $year }}'][1] != future_matrix['{{ $strength->name }}']['{{ $year }}'][0]
                                    }"
                                    >
                                    {{ $future_matrix[$strength->name][$year][0] }}%
                                </span>
                            </td>
                        @endforeach
                    </tr>
                @endforeach

                <tr>
                    <th>
                        {{ __('Market Volumes') }}
                    </th>
                    <td colspan="{{ $project->years->count() + $project->extra_years->count() }}"></td>
                </tr>
                @foreach ($project->marketMetric->strengths as $strength)
                    <tr>
                        <th>{{ $strength->name }}</td>
                        @foreach ($project->years as $year)
                            <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                                x-data="{editing:false}">
                                <input x-cloak x-ref="input" wire:model="matrix.{{ $strength->name }}.{{ $year }}.0" x-show="editing" class="w-full" type="text"
                                    />
                                <span x-show="!editing" x-cloak
                                    class="bg-yellow-100 w-full block"
                                    :class="{
                                        'bg-green-200': matrix['{{ $strength->name }}']['{{ $year }}'][2] && matrix['{{ $strength->name }}']['{{ $year }}'][1] == matrix['{{ $strength->name }}']['{{ $year }}'][0],
                                        'bg-red-200': matrix['{{ $strength->name }}']['{{ $year }}'][1] != matrix['{{ $strength->name }}']['{{ $year }}'][0]
                                    }"
                                    >
                                    {{ number_format($matrix[$strength->name][$year][0] / 1.0e+6, 2) . 'M' }}
                                </span>
                            </td>
                        @endforeach
                        @foreach ($project->extra_years as $year)
                            <td>
                                <span>
                                    {{ number_format($this->calculate_vol($year, $strength->name, $reevaluate) / 1e+6, 2) . 'M' }}
                                </span>
                            </td>
                        @endforeach
                    </tr>
                @endforeach

                <tr>
                    <th>
                        {{ __('Market Sales') }}
                    </th>
                    <td colspan="{{ $project->years->count() + $project->extra_years->count() }}"></td>
                </tr>
                @foreach ($project->marketMetric->strengths as $strength)
                    <tr>
                        <th>{{ $strength->name }}</td>
                        @foreach ($project->years as $year)
                            <td>{{ number_format($strength->get_sales($year) / 1e+6, 2) . 'M' }}</td>
                        @endforeach
                        @foreach ($project->extra_years as $year)
                            <td class="text-center">-</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <section class="lock-div mt-8">
        <table>
            <thead>
                <tr>
                    <th>Strengths</th>
                    <th>Total</th>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <th>{{ date('Y', strtotime($year)) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="whitespace-nowrap">
                        {{ __('Molecule P/L') }}
                    </th>
                    <td colspan="{{ $project->years->count() + $project->extra_years->count() }}"></td>
                </tr>
                @foreach($project->marketMetric->strengths as $strength)
                    <tr>
                        <th class="whitespace-nowrap">{{ $strength->name }}</th>
                        <td>
                            {{ number_format($this->total_mol_pnl_by_strength($strength->name) / 1e+6, 2) . 'M' }}
                        </td>
                        @foreach ($project->xMonthsFromLaunch() as $year)
                            <td>
                                {{ number_format($this->calculate_mol_pnl($strength->name, $year) / 1e+6, 2) . 'M' }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                <tr>
                    <th>Total</th>
                    <td>
                        {{ number_format($this->total_mol_pnl() / 1e+6, 2) . 'M' }}
                    </td>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td>
                            {{ number_format($this->total_mol_pnl_by_year($year) / 1e+6, 2) . 'M' }}
                        </td>
                    @endforeach
                </tr>

                <tr>
                    <th class="whitespace-nowrap">
                        {{ __('COGS') }}
                    </th>
                    <td colspan="{{ $project->years->count() + $project->extra_years->count() }}"></td>
                </tr>
                @foreach($project->marketMetric->strengths as $strength)
                    <tr>
                        <th class="whitespace-nowrap">{{ $strength->name }}</th>
                        <td>
                            {{ number_format($this->total_cogs_by_strength($strength->name) / 1e+6, 2) . 'M' }}
                        </td>
                        @foreach ($project->xMonthsFromLaunch() as $year)
                            <td>
                                {{ number_format($this->calculate_cogs($strength->name, $year) / 1e+6, 2) . 'M' }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                <tr>
                    <th>Total</th>
                    <td>
                        {{ number_format($this->total_cogs() / 1e+6, 2) . 'M' }}
                    </td>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td>
                            {{ number_format($this->total_cogs_by_year($year) / 1e+6, 2) . 'M' }}
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
        <hr class="my-4">
    </section>

    <section
        class="bg-blue-100 p-4 rounded m-4 overflow-x-auto">
        <h2 class="text-2xl flex items-center">
            INFO
            <span wire:click="save" class="cursor-pointer px-4 text-lg">
                💾
            </span>
        </h2>
        <table>
            <thead>
                <tr>
                <th>Year</th>
                @foreach ($project->xMonthsFromLaunch() as $year)
                    <th class="border w-20 border-black">{{ date('Y', strtotime($year)) }}</th>
                @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Sales Months</td>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td class="border w-20 border-gray-800">
                            {{ $extra_info[$year]['sales_months'] }}
                        </td>
                    @endforeach
                </tr>
                <tr>
                <td>Expected Competitors</td>
                @foreach ($project->xMonthsFromLaunch() as $year)
                    <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                        x-data="{editing:false}" class="w-20 border border-gray-800">
                        <input x-cloak x-ref="input" wire:model="extra_info.{{ $year }}.expected_competitors.0"
                            x-show="editing" class="w-20" type="text"/>
                        <span x-show="!editing" x-cloak
                            class="bg-yellow-100 w-full block"
                            :class="{
                                'bg-green-200': extra_info['{{ $year }}']['expected_competitors'][1] == extra_info['{{ $year }}']['expected_competitors'][0],
                                'bg-red-200': extra_info['{{ $year }}']['expected_competitors'][1] != extra_info['{{ $year }}']['expected_competitors'][0]
                            }"
                        >
                            {{ $extra_info[$year]['expected_competitors'][0] }}
                        </span>
                    </td>
                @endforeach
                </tr>
                <tr>
                <td>Order of Entry</td>
                @foreach ($project->xMonthsFromLaunch() as $year)
                    <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                        x-data="{editing:false}" class="w-20 border border-gray-800">
                        <input x-cloak x-ref="input" wire:model="extra_info.{{ $year }}.order_of_entry.0"
                            x-show="editing" class="w-20" type="text"/>
                        <span x-show="!editing" x-cloak
                            class="bg-yellow-100 w-full block"
                            :class="{
                                'bg-green-200': extra_info['{{ $year }}']['order_of_entry'][1] == extra_info['{{ $year }}']['order_of_entry'][0],
                                'bg-red-200': extra_info['{{ $year }}']['order_of_entry'][1] != extra_info['{{ $year }}']['order_of_entry'][0]
                            }"
                        >
                            {{ $extra_info[$year]['order_of_entry'][0] }}
                        </span>
                    </td>
                @endforeach
                </tr>
                <td>Market Share</td>
                @foreach ($project->xMonthsFromLaunch() as $year)
                    <td class="border w-20 border-gray-800">
                        {{ $this->get_market_share($year) . '%' }}
                    </td>
                @endforeach
                </tr>
                <tr>
                <td>Effective Market Share</td>
                @foreach ($project->xMonthsFromLaunch() as $year)
                    <td class="border w-20 border-gray-800">
                        {{ $this->get_effective_market_share($year) . '%' }}
                    </td>
                @endforeach
                </tr>
                @foreach($project->marketMetric->strengths as $strength)
                    <tr>
                        <td>{{ $strength->name }}</td>
                        @foreach ($project->xMonthsFromLaunch() as $year)
                            <td class="border w-20 border-gray-800">
                                {{ $this->get_market_size($strength->name, $year) }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr>
    </section>

    <section class="bg-blue-100 p-4 rounded m-4 overflow-x-auto"
        x-data="{spu_growth_matrix: @entangle('spu_growth_matrix'), loss: @entangle('loss')}"
    >
        <h2 class="text-2xl">Selling Price / Unit</h2>
        <table>
            <thead>
                <tr>
                    <th class="border border-black">Selling Price / Unit</th>
                    <th class="border border-black">Growth Percent</th>
                    <th class="border w-20 border-black">Current</th>
                    <th class="border w-20 border-black">Loe</th>
                    <th x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                        x-data="{editing:false}" class="border border-gray-800">
                        <input x-cloak x-ref="input" wire:model="loss.0"
                            x-show="editing" type="text"/>
                        <span x-show="!editing" x-cloak
                            class="bg-yellow-100 w-full block"
                            :class="{
                                'bg-green-200': loss[1] == loss[0],
                                'bg-red-200': loss[1] != loss[0]
                            }"
                        >
                            {{ $loss[0] . '%' }}
                        </span>
                    </th>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <th class="border w-20 border-black">
                            {{ date('Y', strtotime($year)) }}
                            BWAC: {{ 
                                collect(config('comp_matrix'))
                                    ->where('no_of_players', $extra_info[$year]['expected_competitors'][0])
                                    ->pluck('bwac')->first();
                             }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($project->marketMetric->strengths as $strength)
                    <tr>
                        <td class="border border-gray-800">{{ $strength->name }}</td>
                        <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                            x-data="{editing:false}" class="border border-gray-800">
                            <input x-cloak x-ref="input" wire:model="spu_growth_matrix.{{ $strength->name }}.0"
                                x-show="editing" type="text"/>
                            <span x-show="!editing" x-cloak
                                class="bg-yellow-100 w-full block"
                                :class="{
                                    'bg-green-200': spu_growth_matrix['{{ $strength->name }}'][1] == spu_growth_matrix['{{ $strength->name }}'][0],
                                    'bg-red-200': spu_growth_matrix['{{ $strength->name }}'][1] != spu_growth_matrix['{{ $strength->name }}'][0]
                                }"
                            >
                                {{ $spu_growth_matrix[$strength->name][0] }}
                            </span>
                        </td>
                        <td class="border w-20 border-gray-800">
                            {{
                                number_format(
                                    $current_matrix[$strength->name]
                                , 2)
                            }}
                        </td>
                        <td class="border w-20 border-gray-800">
                            {{  number_format (
                                $current_matrix[$strength->name]
                                * (1 + ($spu_growth_matrix[$strength->name][0] / 100)) ** $project->xMonthsFromLaunch()->count()
                                , 2)
                            }}
                        </td>
                        <td class="border w-20 border-gray-800">
                            {{ $loss[0] . '%' }}
                        </td>
                        @foreach ($project->xMonthsFromLaunch() as $year)
                            <td class="border w-20 border-gray-800">
                                {{ number_format($spu_values[$strength->name][$year], 2) }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr>
    </section>

    <section class="bg-blue-100 p-4 rounded m-4 overflow-x-auto"
        x-data="{cogs: @entangle('cogs'), actuals: @entangle('actuals')}"
    >
        <h2 class="text-2xl">COGS / Unit</h2>
        <table>
            <thead>
                <tr>
                    <th class="border border-black">COGS / Unit</th>
                    <th class="border border-black">Actuals</th>
                    <th x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                        x-data="{editing:false}" class="border border-gray-800">
                        <input x-cloak x-ref="input" wire:model="cogs.0"
                            x-show="editing" type="text"/>
                        <span x-show="!editing" x-cloak
                            class="bg-yellow-100 w-full block"
                            :class="{
                                'bg-green-200': cogs[1] == cogs[0],
                                'bg-red-200': cogs[1] != cogs[0]
                            }"
                        >
                            {{ $cogs[0] . '%' }}
                        </span>
                    </th>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <th class="border w-20 border-black">{{ date('Y', strtotime($year)) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($project->marketMetric->strengths as $strength)
                    <tr>
                        <td class="border border-gray-800">{{ $strength->name }}</td>
                        <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                            x-data="{editing:false}" class="border border-gray-800">
                            <input x-cloak x-ref="input" wire:model="actuals.{{ $strength->name }}.0"
                                x-show="editing" type="text"/>
                            <span x-show="!editing" x-cloak
                                class="bg-yellow-100 w-full block"
                                :class="{
                                    'bg-green-200': actuals['{{ $strength->name }}'][1] == actuals['{{ $strength->name }}'][0],
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
        <hr>
    </section>

    <section class="bg-blue-100 p-4 rounded m-4 overflow-x-auto"
        x-data
    >
        <h2 class="text-2xl">Gross Profit</h2>
        <table>
            <thead>
                <tr>
                    <th class="border border-black">Year</th>
                    <th class="border border-black">Total</th>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <th class="border w-20 border-black">{{ date('Y', strtotime($year)) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-gray-800">Gross Profit</td>
                    <td class="border w-20 border-gray-800">
                        {{ number_format($this->gross_profit_total() / 1e+6, 2) . 'M' }}
                    </td>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td class="border w-20 border-gray-800">
                            {{ number_format($this->gross_profit_by_year($year) / 1e+6, 2) . 'M' }}
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="border border-gray-800">Gross Profit %</td>
                    <td class="border w-20 border-gray-800">
                        {{ number_format($this->gross_profit_percent_total(), 2) . '%' }}
                    </td>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td class="border w-20 border-gray-800">
                            {{ number_format($this->gross_profit_percent_by_year($year), 2) . '%' }}
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
        <hr>
    </section>
    <section class="bg-blue-100 p-4 rounded m-4 overflow-x-auto"
        x-data="{operatings: @entangle('operatings')}"
    >
        <h2 class="text-2xl">Operating Costs</h2>
        <table>
            <thead>
                <tr>
                    <th class="border border-black">Year</th>
                    <th class="border border-black">Total</th>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <th class="border w-20 border-black">{{ date('Y', strtotime($year)) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-gray-800">Development Cost</td>
                    <td class="border w-20 border-gray-800">
                        {{ $this->get_operating_cost_by_type('development_cost') }}
                    </td>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                            x-data="{editing:false}" class="w-20 border border-gray-800" >
                            <input x-cloak x-ref="input" wire:model="operatings.{{ $year }}.development_cost.0"
                                x-show="editing" class="w-20" type="text"/>
                            <span x-show="!editing" x-cloak
                                class="bg-yellow-100 w-full block"
                                :class="{
                                    'bg-green-200': operatings['{{ $year }}']['development_cost'][1] == operatings['{{ $year }}']['development_cost'][0],
                                    'bg-red-200': operatings['{{ $year }}']['development_cost'][1] != operatings['{{ $year }}']['development_cost'][0]
                                }"
                            >
                                {{ $operatings[$year]['development_cost'][0] }}
                            </span>
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="border border-gray-800">Litigation Cost</td>
                    <td class="border w-20 border-gray-800">
                        {{ $this->get_operating_cost_by_type('litigation_cost') }}
                    </td>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                            x-data="{editing:false}" class="w-20 border border-gray-800">
                            <input x-cloak x-ref="input" wire:model="operatings.{{ $year }}.litigation_cost.0"
                                x-show="editing" class="w-20" type="text"/>
                            <span x-show="!editing" x-cloak
                                class="bg-yellow-100 w-full block"
                                :class="{
                                    'bg-green-200': operatings['{{ $year }}']['litigation_cost'][1] == operatings['{{ $year }}']['litigation_cost'][0],
                                    'bg-red-200': operatings['{{ $year }}']['litigation_cost'][1] != operatings['{{ $year }}']['litigation_cost'][0]
                                }"
                            >
                                {{ $operatings[$year]['litigation_cost'][0] }}
                            </span>
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="border border-gray-800">Other Costs</td>
                    <td class="border w-20 border-gray-800">
                        {{ $this->get_operating_cost_by_type('other_cost') }}
                    </td>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                            x-data="{editing:false}" class="w-20 border border-gray-800">
                            <input x-cloak x-ref="input" wire:model="operatings.{{ $year }}.other_cost.0"
                                x-show="editing" class="w-20" type="text"/>
                            <span x-show="!editing" x-cloak
                                class="bg-yellow-100 w-full block"
                                :class="{
                                    'bg-green-200': operatings['{{ $year }}']['other_cost'][1] == operatings['{{ $year }}']['other_cost'][0],
                                    'bg-red-200': operatings['{{ $year }}']['other_cost'][1] != operatings['{{ $year }}']['other_cost'][0]
                                }"
                            >
                                {{ $operatings[$year]['other_cost'][0] }}
                            </span>
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="border border-gray-800">Total Operating Costs</td>
                    <td class="border w-20 border-gray-800">
                        {{ $this->get_operating_total() }}
                    </td>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td class="border w-20 border-gray-800">
                            {{ $this->get_operating_cost_by_year($year) }}
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="border border-gray-800">PBT</td>
                    <td class="border w-20 border-gray-800">
                        {{ number_format(($this->gross_profit_total($year) - $this->get_operating_total($year)) / 1e+6, 2) . 'M' }}
                    </td>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td class="border w-20 border-gray-800">
                            {{ number_format(($this->gross_profit_by_year($year) - $this->get_operating_cost_by_year($year)) / 1e+6, 2) . 'M' }}
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
        <hr>
    </section>
</div>
