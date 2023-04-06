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

    <section class="bg-blue-100 p-4 rounded m-4 overflow-x-auto">
        <h2 class="text-2xl">Selling Price / Unit</h2>
        <table>
            <thead>
                <tr>
                    <th class="border border-black">Selling Price / Unit</th>
                    <th class="border border-black">Growth Percent</th>
                    <th class="border w-20 border-black">Current</th>
                    <th class="border w-20 border-black">Loe</th>
                    <th class="border w-20 border-black">-5</th>
                    @foreach ($project->xMonthsFromLaunch() as $year)
                        <th class="border w-20 border-black">{{ date('Y', strtotime($year)) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($project->marketMetric->strengths as $strength)
                    <tr>
                        <td class="border border-gray-800">{{ $strength->name }}</td>
                        <td class="border border-gray-800">0%</td>
                        <td class="border w-20 border-gray-800">
                            {{
                                number_format(
                                $strength->get_sales($project->years->last()) /
                                (($strength->get_market_volume($project->years->last()) ?? $strength->get_volume($project->years->last())) ?? 1)
                                , 2)
                            }}
                        </td>
                        <td class="border w-20 border-gray-800">
                            {{  number_format (
                                ($strength->get_sales($project->years->last()) /
                                (($strength->get_market_volume($project->years->last()) ?? $strength->get_volume($project->years->last())) ?? 1))
                                * (1 + (0000 / 100)) ** $project->xMonthsFromLaunch()->count()
                                , 2)
                            }}
                        </td>
                        <td class="border w-20 border-gray-800">5%</td>
                        @foreach ($project->xMonthsFromLaunch() as $year)
                            <td class="border w-20 border-gray-800">
                                {{  number_format (
                                    ($strength->get_sales($project->years->last()) /
                                    (($strength->get_market_volume($project->years->last()) ?? $strength->get_volume($project->years->last())) ?? 1))
                                    * (1 + (0000 / 100)) ** $project->xMonthsFromLaunch()->count()
                                    , 2)
                                }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr>
    </section>
</div>