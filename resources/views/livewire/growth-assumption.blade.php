<section class="bg-blue-100 p-4 rounded m-4 overflow-x-auto">
    Growth Assumptions
    <table class="w-full">
        <thead>
            <th class="border border-black">Strengths</th>
            @foreach ($project->years as $year)
                <th class="border w-20 border-black">{{ date('Y', strtotime($year)) }}</th>
            @endforeach
            @foreach ($project->extra_years as $year)
                <th class="border w-20 border-black">{{ date('Y', strtotime($year)) }}</th>
            @endforeach
        </thead>
        <tbody>
            @foreach ($project->marketMetric->strengths as $strength)
                <tr>
                    <td class="border border-black">{{ $strength->name }}</td>
                    @foreach ($project->years as $year)
                        <td x-text="calc_perc('{{ $year }}', '{{ $strength->name }}')" class="border border-gray-800"></td>
                    @endforeach
                    @foreach ($project->extra_years as $year)
                        <td x-on:click="editing=true; $nextTick(() => {$refs.input.select();});" x-on:click.outside="editing=false"
                            x-data="{editing:false}" class="w-20 border border-gray-800">
                            <input x-cloak x-ref="input" x-show="editing" class="w-20" type="text"
                                x-model="future_matrix['{{ $strength->name }}']['{{ $year }}']" />
                            <span x-show="!editing" x-cloak
                                class="bg-yellow-100 w-full block"
                                x-text="`${future_matrix['{{ $strength->name }}']['{{ $year }}']}%`"></span>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
</section>