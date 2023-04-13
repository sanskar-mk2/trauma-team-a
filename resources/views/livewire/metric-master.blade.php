<div class="max-w-7xl">
    <section x-data="{project_name: @entangle('project_name')}" class="bg-blue-100 p-4 rounded m-4 overflow-x-auto flex justify-between">
        <div>
            <h1 class="font-bold text-xl">{{ $project->id }}. 
                <input type="text" class="px-2" wire:model="project_name.0" :class="{
                    'bg-green-200': project_name[1] == project_name[0],
                    'bg-red-200': project_name[1] != project_name[0]
                }" />
                <span wire:click="save" class="cursor-pointer px-4 text-lg">
                    💾
                </span>
            </h1>
            Launch Date: {{ $project->productMetric->launch_date }}
        </div>
        @include('projects.partials.legend')
    </section>
    <hr>
    {{-- <livewire:growth-assumption :project="$project" /> --}}
    {{-- <livewire:market-volume :project="$project" /> --}}
    {{-- <livewire:market-sale :project="$project" /> --}}
    <livewire:info :project="$project" />
    {{-- <livewire:selling-price :project="$project" /> --}}
</div>
