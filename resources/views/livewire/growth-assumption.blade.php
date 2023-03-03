<section>
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
                        <td class="w-20 border border-gray-800">
                            <input class="w-20" type="text" x-model="future_matrix['{{ $strength->name }}']['{{ $year }}']" />
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
</section>