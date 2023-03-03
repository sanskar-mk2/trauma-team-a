<section class="bg-blue-100 p-4 rounded m-4">
    <p>Market Sales</p>
    <table>
        <thead>
                <th class="border border-black">Strengths</th>
            @foreach ($project->years as $year)
                <th class="border border-black">{{ date('Y', strtotime($year)) }}</th>
            @endforeach
        </thead>
        <tbody>
            @foreach ($project->marketMetric->strengths as $strength)
                <tr>
                    <td class="border border-black">{{ $strength->name }}</td>
                    @foreach ($project->years as $year)
                        <td class="border border-gray-800">{{ $strength->get_sales($year) }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
</section>