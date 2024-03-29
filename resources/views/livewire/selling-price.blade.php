<section class="bg-blue-100 p-4 rounded m-4 overflow-x-auto"
    <h2 class="text-2xl">Selling price</h2>
    <table>
        <thead>
            <th>Selling Price/Unit</th>
            <th>Growth Rate</th>
            <th>Current</th>
            <th>-@LoE</th>
            <th>
                Erosion
                <input class="w-20" type="text" x-model="erosion" />
            </th>
            <th class="border border-black">
                {{ date('Y', strtotime($project->productMetric->launch_date)) }}
                (<span x-text="bwac"></span>%)
            </th>
            @foreach ($project->extraYearsAfterLaunch as $year)
                <th class="border w-20 border-black">{{ date('Y', strtotime($year)) }}
                    (<span x-text="erosion"></span>%)
                </th>
            @endforeach
        </thead>
        <tbody>
            @foreach ($project->marketMetric->strengths as $strength)
                <tr>
                    <td class="border border-gray-800" x-text="'{{ $strength->name }}'">
                    </td>
                    <td class="border border-gray-800">
                        <input class="w-20" type="text" x-model="growth['{{ $strength->name }}']" />
                    </td>
                    <td class="border border-gray-800" x-text="get_current('{{ $strength->name }}')">
                    </td>
                    <td class="border border-gray-800" x-text="loes.find(loe => '{{ $strength->name }}' === loe.name).loe">
                    </td>
                    <td class="border border-gray-800" x-text="erosion">
                    </td>
                    <td>
                        <input class="w-20" type="text" x-model="selling_price['{{ $strength->name }}']['{{ $project->productMetric->launch_date }}']" />
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</section>
