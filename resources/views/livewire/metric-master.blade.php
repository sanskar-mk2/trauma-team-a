<div x-data="growth(
    @js($project->marketMetric->strengths->load('marketDatas')),
    @js($project->years),
    @js($project->extra_years),
)">
    Project Id: {{ $project->id }}
    <hr>
    Project Name: {{ $project->name }}
    <hr>
    <livewire:growth-assumption :project="$project" />
    <livewire:market-volume :project="$project" />
    <livewire:market-sale :project="$project" />
</div>