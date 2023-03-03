<section class="bg-blue-100 p-4 rounded m-4 overflow-x-auto">
    Market Volumes: {{ $project->marketMetric->evaluate_by }}
    <table class="w-full">
        <thead>
                <th class="border border-black">Strengths</th>
            @foreach ($project->years as $year)
                <th class="border border-black">{{ date('Y', strtotime($year)) }}</th>
            @endforeach
            @foreach ($project->extra_years as $year)
                <th class="border border-black">{{ date('Y', strtotime($year)) }}</th>
            @endforeach
        </thead>
        <tbody>
            @foreach ($project->marketMetric->strengths as $strength)
                <tr>
                    <td class="border border-black">{{ $strength->name }}</td>
                    @foreach ($project->years as $year)
                        <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                            x-data="{editing:false}" class="border w-20 border-gray-800">
                            <input x-ref="input" x-cloak x-show="editing" class="w-20" type="text" x-model="matrix['{{ $strength->name }}']['{{ $year }}']" />
                            <span x-show="!editing" x-cloak class="bg-yellow-100 block w-full"
                                x-text="(Math.abs(Number(matrix['{{ $strength->name }}']['{{ $year }}'])) / 1.0e+6).toFixed(2) + 'M'"></span>
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