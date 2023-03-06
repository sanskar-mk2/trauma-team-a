<section x-data="{matrix: @entangle('matrix')}" class="bg-blue-100 p-4 rounded m-4 overflow-x-auto">
    <div class="flex justify-between p-2">
        <div>
            <h3 class="inline text-lg">Market Volumes: {{ $project->marketMetric->evaluate_by }}</h3>
            <span wire:click="saveMatrix"
                class="cursor-pointer px-4 text-lg">
                💾
            </span>
        </div>
        @include('projects.partials.legend')
    </div>
    <table class="w-full">
        <thead>
                <th class="border border-black">Strengths</th>
            @foreach ($project->years as $year)
                <th class="border border-black">{{ date('Y', strtotime($year)) }}</th>
            @endforeach
            @foreach ($project->extra_years as $year)
                @if (date('Y', strtotime($year)) == date('Y', strtotime($project->productMetric->launch_date)))
                    <th class="border bg-purple-200 w-20 border-black">{{ date('Y', strtotime($year)) }}</th>
                @else
                    <th class="border w-20 border-black">{{ date('Y', strtotime($year)) }}</th>
                @endif
            @endforeach
        </thead>
        <tbody>
            @foreach ($project->marketMetric->strengths as $strength)
                <tr>
                    <td class="border border-black">{{ $strength->name }}</td>
                    @foreach ($project->years as $year)
                        <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                            x-data="{editing:false}" class="w-20 border border-gray-800">
                            <input x-cloak x-ref="input" wire:model="matrix.{{ $strength->name }}.{{ $year }}.0" x-show="editing" class="w-20" type="text"
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
                        <td class="border-gray-800 w-20 border" x-text="(Math.abs(Number(calc_vol(@js($year), @js($strength->name)))) / 1.0e+6).toFixed(2) + 'M'"></td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
</section>