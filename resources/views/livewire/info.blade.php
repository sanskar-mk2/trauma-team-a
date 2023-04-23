<div class="p-8" x-data="{ future_matrix: @entangle('future_matrix'), matrix: @entangle('matrix'), extra_info: @entangle('extra_info'), operatings: @entangle('operatings'), spu_growth_matrix: @entangle('spu_growth_matrix'), loss: @entangle('loss'), cogs: @entangle('cogs'), actuals: @entangle('actuals')}" >
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
                <th>Total</th>
            </thead>
            <tbody x-data="{pl_display: false, cogs_display: false, ga_display: false, mv_display: false, ms_display: false, oc_display: false, gp_display: true, info_display: false, su_display: false, cu_display: false}">

                <th class="whitespace-nowrap flex justify-between">
                    {{ __('Info') }}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block"
                        :class="{'rotate-180': info_display}" @click="info_display = !info_display">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                    <td colspan="{{ $project->years->count() + $project->extra_years->count() + 1 }}"></td>
                </th>

                <tr x-cloak x-show="info_display"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-500"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90"
                >
                    <th>Sales Months</th>
                    @foreach ($project->yearsTillLaunch() as $year)
                        <td class="text-center">-</td>
                    @endforeach
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td>
                            {{ $extra_info[$year]['sales_months'] }}
                        </td>
                    @endforeach
                </tr>
                <tr x-cloak x-show="info_display"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-400"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90"
                >
                    <th>Expected Competitors</th>
                    @foreach ($project->yearsTillLaunch() as $year)
                        <td class="text-center">-</td>
                    @endforeach
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                            x-data="{editing:false}">
                            <input x-cloak x-ref="input" wire:model="extra_info.{{ $year }}.expected_competitors.0"
                                x-show="editing" class="w-full" type="text"/>
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
                <tr x-cloak x-show="info_display"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90"
                >
                    <th>Order of Entry</th>
                    @foreach ($project->yearsTillLaunch() as $year)
                        <td class="text-center">-</td>
                    @endforeach
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                            x-data="{editing:false}">
                            <input x-cloak x-ref="input" wire:model="extra_info.{{ $year }}.order_of_entry.0"
                                x-show="editing" class="w-full" type="text"/>
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
                <tr x-cloak x-show="info_display"
                    x-transition:enter="transition ease-out duration-400"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90"
                >
                    <th>Market Share</th>
                    @foreach ($project->yearsTillLaunch() as $year)
                        <td class="text-center">-</td>
                    @endforeach
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td>
                            {{ $this->get_market_share($year) . '%' }}
                        </td>
                    @endforeach
                </tr>
                <tr x-cloak x-show="info_display"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-50"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90"
                >
                    <th>Effective Market Share</th>
                    @foreach ($project->yearsTillLaunch() as $year)
                        <td class="text-center">-</td>
                    @endforeach
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td>
                            {{ $this->get_effective_market_share($year) . '%' }}
                        </td>
                    @endforeach
                </tr>
                @foreach($project->marketMetric->strengths as $strength)
                    <tr x-cloak x-show="info_display"
                        x-transition:enter="transition ease-out duration-600"
                        x-transition:enter-start="opacity-0 transform scale-90"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-0"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-90"
                    >
                        <th>{{ $strength->name }}</th>
                        @foreach ($project->yearsTillLaunch() as $year)
                            <td class="text-center">-</td>
                        @endforeach
                        @foreach ($project->xMonthsFromLaunch() as $year)
                            <td>
                                {{ $this->get_market_size($strength->name, $year) }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach

                <tr>
                    <th class="whitespace-nowrap flex justify-between">
                        {{ __('Molecule P/L') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block"
                            :class="{'rotate-180': pl_display}" @click="pl_display = !pl_display">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </th>
                    @foreach ($project->yearsTillLaunch() as $year)
                        <td class="text-center">-</td>
                    @endforeach
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td>
                            {{ number_format($this->total_mol_pnl_by_year($year) / 1e+6, 2) . 'M' }}
                        </td>
                    @endforeach
                    <td>
                        {{ number_format($this->total_mol_pnl() / 1e+6, 2) . 'M' }}
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
                        @foreach ($project->yearsTillLaunch() as $year)
                            <td class="text-center">-</td>
                        @endforeach
                        @foreach ($project->xMonthsFromLaunch() as $year)
                            <td>
                                {{ number_format($this->calculate_mol_pnl($strength->name, $year) / 1e+6, 2) . 'M' }}
                            </td>
                        @endforeach
                        <td>
                            {{ number_format($this->total_mol_pnl_by_strength($strength->name) / 1e+6, 2) . 'M' }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <th class="whitespace-nowrap flex justify-between">
                        {{ __('COGS') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block"
                            :class="{'rotate-180': cogs_display}" @click="cogs_display = !cogs_display">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </th>
                    @foreach ($project->yearsTillLaunch() as $year)
                        <td class="text-center">-</td>
                    @endforeach
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td>
                            {{ number_format($this->total_cogs_by_year($year) / 1e+6, 2) . 'M' }}
                        </td>
                    @endforeach
                    <td>
                        {{ number_format($this->total_cogs() / 1e+6, 2) . 'M' }}
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
                        @foreach ($project->yearsTillLaunch() as $year)
                            <td class="text-center">-</td>
                        @endforeach
                        @foreach ($project->xMonthsFromLaunch() as $year)
                            <td>
                                {{ number_format($this->calculate_cogs($strength->name, $year) / 1e+6, 2) . 'M' }}
                            </td>
                        @endforeach
                        <td>
                            {{ number_format($this->total_cogs_by_strength($strength->name) / 1e+6, 2) . 'M' }}
                        </td>
                    </tr>
                @endforeach

                <tr>
                    <th>Gross Profit</th>
                    @foreach ($project->yearsTillLaunch() as $year)
                        <td class="text-center">-</td>
                    @endforeach
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td>
                            {{ number_format($this->gross_profit_by_year($year) / 1e+6, 2) . 'M' }}
                        </td>
                    @endforeach
                    <td>
                        {{ number_format($this->gross_profit_total() / 1e+6, 2) . 'M' }}
                    </td>
                </tr>
                <tr>
                    <th>Gross Profit %</th>
                    @foreach ($project->yearsTillLaunch() as $year)
                        <td class="text-center">-</td>
                    @endforeach
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td>
                            {{ number_format($this->gross_profit_percent_by_year($year), 2) . '%' }}
                        </td>
                    @endforeach
                    <td>
                        {{ number_format($this->gross_profit_percent_total(), 2) . '%' }}
                    </td>
                </tr>



                <tr>
                    <th class="whitespace-nowrap flex justify-between">
                        {{ __('PBT') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block"
                            :class="{'rotate-180': oc_display}" @click="oc_display = !oc_display">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </th>
                    @foreach ($project->yearsTillLaunch() as $year)
                        <td class="text-center">-</td>
                    @endforeach
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td>
                            {{ number_format(($this->gross_profit_by_year($year) - $this->get_operating_cost_by_year($year)) / 1e+6, 2) . 'M' }}
                        </td>
                    @endforeach
                    <td>
                        {{ number_format(($this->gross_profit_total($year) - $this->get_operating_total($year)) / 1e+6, 2) . 'M' }}
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
                    @foreach ($project->yearsTillLaunch() as $year)
                        <td class="text-center">-</td>
                    @endforeach
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                            x-data="{editing:false}">
                            <input class="w-full" x-cloak x-ref="input" wire:model="operatings.{{ $year }}.development_cost.0"
                                x-show="editing" type="text"/>
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
                    @foreach ($project->yearsTillLaunch() as $year)
                        <td class="text-center">-</td>
                    @endforeach
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                            x-data="{editing:false}">
                            <input class="w-full" x-cloak x-ref="input" wire:model="operatings.{{ $year }}.litigation_cost.0"
                                x-show="editing" type="text"/>
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
                    @foreach ($project->yearsTillLaunch() as $year)
                        <td class="text-center">-</td>
                    @endforeach
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                            x-data="{editing:false}">
                            <input x-cloak x-ref="input" wire:model="operatings.{{ $year }}.other_cost.0" class="w-full"
                                x-show="editing" class="w-full" type="text"/>
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
                    <td>
                        {{ $this->get_operating_cost_by_type('other_cost') }}
                    </td>
                </tr>
                <tr x-cloak x-show="oc_display"
                    x-transition:enter="transition ease-out duration-400"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90"
                >
                    <th>Total Operating Costs</th>
                    @foreach ($project->yearsTillLaunch() as $year)
                        <td class="text-center">-</td>
                    @endforeach
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <td class="border w-20 border-gray-800">
                            {{ $this->get_operating_cost_by_year($year) }}
                        </td>
                    @endforeach
                    <td class="border w-20 border-gray-800">
                        {{ $this->get_operating_total() }}
                    </td>
                </tr>

                <tr>
                    <th class="whitespace-nowrap flex justify-between">
                        {{ __('Growth Assumptions') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block"
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
                    <th class="whitespace-nowrap flex justify-between">
                        {{ __('Market Volumes') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block"
                            :class="{'rotate-180': mv_display}" @click="mv_display = !mv_display">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </th>
                    <td colspan="{{ $project->years->count() + $project->extra_years->count() + 1 }}"></td>
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
                    <th class="whitespace-nowrap flex justify-between">
                        {{ __('Market Sales') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block"
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
                            <td>{{ number_format($strength->get_sales($year) / 1e+6, 2) . 'M' }}</td>
                        @endforeach
                        @foreach ($project->extra_years as $year)
                            <td class="text-center">-</td>
                        @endforeach
                    </tr>
                @endforeach

                <tr>
                    <th class="whitespace-nowrap flex justify-between">
                        {{ __('Selling Price / Unit') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block"
                            :class="{'rotate-180': su_display}" @click="su_display = !su_display">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </th>
                    <td colspan="{{ $project->yearsTillLaunch()->count() - 4 }}">-</td>
                    <td class="whitespace-nowrap">Growth Percent</td>
                    <td>Current</td>
                    <td>Loe</td>
                    <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                        x-data="{editing:false}">
                        <input x-cloak x-ref="input" wire:model="loss.0" class="w-full"
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
                    </td>
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
                        @foreach (collect($project->yearsTillLaunch())->slice(0, -4) as $year)
                            <td class="text-center">-</td>
                        @endforeach
                        <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                            x-data="{editing:false}">
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
                        <td>
                            {{
                                number_format(
                                    $current_matrix[$strength->name]
                                , 2)
                            }}
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

                <tr>
                    <th class="whitespace-nowrap flex justify-between">
                        {{ __('COGS / Unit') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block"
                            :class="{'rotate-180': cu_display}" @click="cu_display = !cu_display">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </th>
                    @foreach (collect($project->yearsTillLaunch())->slice(0, -2) as $year)
                        <td class="text-center">-</td>
                    @endforeach
                    <td>Actuals</td>
                    <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                        x-data="{editing:false}">
                        <input x-cloak x-ref="input" wire:model="cogs.0" class="w-full"
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
                        @foreach(collect($project->yearsTillLaunch())->slice(0, -2) as $year)
                            <td class="text-center">-</td>
                        @endforeach
                        <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                            x-data="{editing:false}">
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
    </section>
</div>
