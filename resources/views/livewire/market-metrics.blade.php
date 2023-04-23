<div class="w-full" x-data="{ valid_molecule: @entangle('valid_molecule'), product_metric_vali: @entangle('product_metric_vali'), evaluate_by: @entangle('evaluate_by'), step: @entangle('step'), selected_form: @entangle('selected_form'), project_id: @entangle('project_id') }">
    <form class="flex w-full flex-col gap-4">
        <section class="flex gap-2 mt-4 flex-col">
            {{-- <h3 class="text-xl font-bold underline">
                Market Metrics: Step {{ $step + 1 }}
            </h3> --}}
            {{-- Step 0 Start --}}
            <div x-data="{this_step: 0}" x-cloak class="flex items-end">
                <div class="w-full flex flex-col mb-2">
                    <label for="search">Search Molecules</label>
                    <input
                        type="text"
                        list="searchList"
                        placeholder="Search Molecules..."
                        wire:model="search"
                        id="search"
                        :disabled="step!==this_step"
                        class="border border-gray-400 p-2 w-full rounded"
                    />
                </div>
                <datalist id="searchList">
                    @foreach ($searchList as $item)
                        <option value="{{ $item }}">
                    @endforeach
                </datalist>
                <p class="p-2 w-full text-lg" :class="{'text-red-500':!valid_molecule,'text-green-500':valid_molecule}">
                    {{ $valid_molecule ? $search : "Select A Valid Molecule" }}
                </p>
            </div>
            {{-- Step 0 End --}}
            {{-- Step 1 Start --}}
            <div x-data="{this_step: 1}" class="flex items-end" x-cloak x-show="step>=this_step">
                <div class="w-full flex flex-col mb-2">
                    <label for="form">Select Form</label>
                    <select wire:change="get_strengths" wire:model="selected_form"
                        id="form"
                        class="border border-gray-400 p-2 w-full rounded"
                        :class="{'border-red-500':!valid_molecule,'border-green-500':valid_molecule}"
                        :disabled="step!==this_step"
                    >
                        <option selected disabled value="">Select A Form</option>
                        @foreach ($forms as $form)
                            <option value="{{ $form }}">{{ $form }}</option>
                        @endforeach
                    </select>
                </div>
                <p class="p-2 text-lg w-full text-green-500">
                    {{ $selected_form }}
                </p>
            </div>
            {{-- Step 1 End --}}
            {{-- Step 2 Start --}}
            <div class="flex flex-col mb-2" x-data="{this_step: 2, local_selected: @entangle('selected_strengths').defer, strengths: @entangle('strengths')}" x-cloak>
                <div class="flex flex-col mb-2">
                    <label x-show="step>=this_step">Select Strength</label>
                    <div x-show="step===this_step" class="flex flex-wrap h-fit max-h-48 bg-gray-100 rounded overflow-y-auto">
                        <template x-for="strength in strengths" :key="strength.replace(' ', '-')" >
                            <label class="bg-gray-200 p-2 m-2 rounded cursor-pointer" 
                                :for="strength.replace(' ', '-')">
                                <input
                                    type="checkbox" x-model="local_selected"
                                    :value="strength.replace(' ', '-')"
                                    :id="strength.replace(' ', '-')"
                                >
                                <span x-text="strength"></span>
                            </label>
                        </template>
                    </div>
                </div>
                <div class="flex flex-wrap gap-1 items-center">
                    @foreach ($selected_strengths as $strength)
                        <span class="bg-gray-200 text-lg text-green-600 font-bold p-2 rounded">
                            {{ $strength }}
                        </span>
                    @endforeach
                </div>
            </div>
            {{-- Step 2 End --}}
            {{-- Step 3 Start --}}
            <div class="flex items-end" x-data="{this_step:3}" :disabled="step>this_step" x-cloak x-show="step>=this_step">
                <div class="w-full flex flex-col mb-2">
                    <label for="evaluate_by">Evaluate By</label>
                    <select wire:change="autofill" wire:model="evaluate_by" class="border border-gray-400 p-2 w-full rounded"
                        id="evaluate_by"
                        :disabled="step!==this_step"
                    >
                        <option disabled selected value="">Select Eaches/Units</option>
                        <option value="Eaches">Eaches</option>
                        <option value="Units">Units</option>
                    </select>
                </div>
                <p class="p-2 text-lg w-full text-green-500">
                    {{ $evaluate_by }}
                </p>
            </div>
            {{-- Step 3 End --}}
            <div class="grid grid-cols-2" x-cloak x-show="step>=4">
                <div class="flex flex-col">
                    <label>Brand Generic</label>
                    <p class="text-lg w-full text-green-500">
                        {{ $brand_generic}}
                    </p>
                </div>
                <div class="flex flex-col">
                    <label>Category</label>
                    <p class="text-lg w-full text-green-500">
                        {{ $category }}
                    </p>
                </div>
            </div>
            <div class="flex flex-col" x-cloak x-show="step>=4">
                <label>Products</label>
                <p class="w-full flex flex-wrap gap-1 text-green-500">
                    @foreach ($products as $product)
                        <span class="bg-gray-200 text-lg text-green-600 font-bold p-1 rounded">
                            {{ $product }}
                        </span>
                    @endforeach
                </p>
            </div>
        </section>
        <section x-cloak x-show="step>=4" class="flex gap-2 mt-4 flex-col">
            <p class="bg-green-200 w-1/2 rounded py-3 pl-4">☑ Market Metrics Saved</p>
            <h3 class="text-xl font-bold underline">
                Product Metrics
            </h3>
            <div class="grid grid-cols-3 gap-4">
                <div class="flex flex-col">
                    <label for="launch_date">Launch Date</label>
                    <input type="date" wire:change.defer="vali" wire:model="launch_date" min="{{ date('Y-m-d') }}"
                        class="border border-gray-400 p-2 w-full rounded"
                        id="launch_date"
                        :disabled="step!==4"
                    >
                </div>
                <div class="flex flex-col">
                    <label for="expected_competitors">Expected Competitors</label>
                    <input wire:change.defer="vali" type="number" wire:model="expected_competitors"
                        class="border border-gray-400 p-2 w-full rounded"
                        id="expected_competitors"
                        min="0"
                        :disabled="step!==4"
                    >
                </div>
                <div class="flex flex-col">
                    <label for="order_of_entry">Order of Entry</label>
                    <input type="number" wire:change.defer="vali" wire:model="order_of_entry"
                        class="border border-gray-400 p-2 w-full rounded"
                        id="order_of_entry"
                        min="1"
                        :disabled="step!==4"
                    >
                </div>
                <div class="flex flex-col">
                    <label for="cogs">COGS (in %)</label>
                    <input type="number" wire:change.defer="vali" wire:model="cogs"
                        min="0" max="100" step="0.01"
                        class="border border-gray-400 p-2 w-full rounded"
                        id="cogs"
                        :disabled="step!==4"
                    >
                </div>
                <div class="flex flex-col">
                    <label for="development_cost">Development Cost</label>
                    <input type="number" wire:change.defer="vali" wire:model="development_cost"
                        class="border border-gray-400 p-2 w-full rounded"
                        id="development_cost"
                        :disabled="step!==4"
                    >
                </div>
            </div>
        </section>
        <p class="bg-green-200 w-1/2 rounded py-3 pl-4" x-cloak x-show="step===5">☑ Product Metrics Saved</p>
    </form>
    <div class="w-full flex flex-start my-8">
        {{-- <button :disabled="step===0" wire:click="previous_step" class="bg-green-500 p-2 rounded text-white">
            Previous
        </button> --}}
        <button :disabled=
            "(step===3&&evaluate_by==='')||
            (step===4&&!product_metric_vali)||
            !valid_molecule||
            (step===1&&selected_form==='')"
            wire:click="next_step" class="bg-green-500 p-2 rounded text-white w-1/2"
            x-cloak x-show="step<5"
        >
            Next
        </button>
        <a
            class="bg-green-500 p-2 text-center rounded text-white w-1/2"
            x-cloak x-show="step>4"
            :href="`/projects/${project_id}`"
        >
            View
        </a>
    </div>
</div>
