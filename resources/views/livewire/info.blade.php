<section class="bg-blue-100 p-4 rounded m-4 overflow-x-auto">
    <h2 class="text-2xl">INFO</h2>
    <table>
        <thead>
            <tr>
            <th>Year</th>
            @foreach ($project->extra_years as $year)
                <th class="border w-20 border-black">{{ date('Y', strtotime($year)) }}</th>
            @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
            <td>Sales Months</td>
            @foreach ($project->extra_years as $year)
                <td class="border w-20 border-gray-800" x-text="extra_info['{{ $year }}']['sales_months']">
                </td>
            @endforeach
            </tr>
            <tr>
            <td>Expected Competitors</td>
            @foreach ($project->extra_years as $year)

                <td class="border w-20 border-gray-800">
                    <input class="w-20" type="text" x-model="extra_info['{{ $year }}']['expected_competitors']" />
                </td>
            @endforeach
            </tr>
            <tr>
            <td>Order of Entry</td>
            @foreach ($project->extra_years as $year)
                <td class="border w-20 border-gray-800">
                    <input class="w-20" type="text" x-model="extra_info['{{ $year }}']['order_of_entry']" />
                </td>
            @endforeach
            </tr>
            <td>Market Share</td>
            @foreach ($project->extra_years as $year)
                <td class="border w-20 border-gray-800" x-text="get_market_share('{{ $year }}')">
                </td>
            @endforeach
            </tr>
            <tr>
            <td>Effective Market Share</td>
            @foreach ($project->extra_years as $year)
                <td class="border w-20 border-gray-800" x-text="get_effective_market_share('{{ $year }}')">
                </td>
            @endforeach
            </tr>
            @foreach($project->marketMetric->strengths as $strength)
                <tr>
                    <td>{{ $strength->name }}</td>
                    @foreach ($project->extra_years as $year)
                        <td class="border w-20 border-gray-800" x-text="get_market_size('{{ $strength->name }}', '{{ $year }}')">
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
</section>