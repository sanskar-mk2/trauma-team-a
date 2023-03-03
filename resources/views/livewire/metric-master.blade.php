<div x-data="growth(
    @js($project->marketMetric->strengths->load('marketDatas')),
    @js($project->years),
    @js($project->extra_years),
    @js($project->productMetric->expected_competitors),
    @js($project->productMetric->order_of_entry),
    @js($project->extraYearsWithLaunch)
)">
    Project Id: {{ $project->id }}
    <hr>
    Project Name: {{ $project->name }}
    <hr>
    <livewire:growth-assumption :project="$project" />
    <livewire:market-volume :project="$project" />
    <livewire:market-sale :project="$project" />
    <livewire:info :project="$project" />
    {{-- <livewire:selling-price :project="$project" /> --}}
</div>