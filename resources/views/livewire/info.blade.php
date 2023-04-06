<div>
    <section x-data="{extra_info: @entangle('extra_info')}"
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
        x-data
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
</div>