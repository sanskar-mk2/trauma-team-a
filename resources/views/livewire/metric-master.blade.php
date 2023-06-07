<div class="w-full">
    <section x-data="{project_name: @entangle('project_name')}" class="px-4 rounded mx-4 mt-4 overflow-x-auto flex justify-between">
        <div>
            <h1 class="font-bold text-xl">
                <!-- {{ $project->id }}.  -->
                <input type="text" class="px-2 rounded" wire:model="project_name.0" :class="{
                    'bg-gray-200': project_name[1] == project_name[0],
                    'bg-red-200': project_name[1] != project_name[0]
                }" />
                <span wire:click="save" class="cursor-pointer px-4 text-lg">
                    💾
                </span>
            </h1>
        </div>
        @include('projects.partials.legend')
    </section>
    <livewire:info :project="$project" />
</div>
