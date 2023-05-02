<div class="w-full">
    <section x-data="{project_name: @entangle('project_name')}" class="px-4 rounded mx-4 mt-4 overflow-x-auto flex justify-between">
        <div>
            <h1 class="font-bold text-xl">{{ $project->id }}. 
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
    <div class="flex justify-around px-8 py-4 gap-4">
        <a
            href="#"
            class="relative w-full block rounded-sm border-t-4 border-pink-600 p-1 pl-4 shadow-xl"
        >
            <div class="flex items-center gap-1">
                <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 text-pink-600 sm:h-8 sm:w-8"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z"
                    />
                </svg>

                <h3 class="text-3xl font-bold">100</h3>
            </div>

            <p class="mt-4 font-medium text-gray-500">
                5 Year Revenue
            </p>
        </a>

        <a
            href="#"
            class="relative w-full block rounded-sm border-t-4 border-yellow-600 p-1 pl-4 shadow-xl"
        >
            <div class="flex items-center gap-1">
                <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 text-yellow-600 sm:h-8 sm:w-8"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z"
                    />
                </svg>

                <h3 class="text-3xl font-bold">100</h3>
            </div>

            <p class="mt-4 font-medium text-gray-500">
                NPV
            </p>
        </a>

        <a
            href="#"
            class="relative w-full block rounded-sm border-t-4 border-purple-600 p-1 pl-4 shadow-xl"
        >
            <div class="flex items-center gap-1">
                <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 text-purple-600 sm:h-8 sm:w-8"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z"
                    />
                </svg>

                <h3 class="text-3xl font-bold">100</h3>
            </div>

            <p class="mt-4 font-medium text-gray-500">
                ??
            </p>
        </a>

        <a
            href="#"
            class="relative w-full block rounded-sm border-t-4 border-orange-600 p-1 pl-4 shadow-xl"
        >
            <div class="flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-orange-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                <h3 class="text-3xl font-bold">
                    {{ $project->productMetric->launch_date }}
                </h3>
            </div>

            <p class="mt-4 font-medium text-gray-500">
                Launch Date
            </p>
        </a>
    </div>

    <hr>
    <livewire:info :project="$project" />
</div>
