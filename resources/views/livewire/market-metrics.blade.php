<div x-data="{ valid_molecule: @entangle('valid_molecule'), product_metric_vali: @entangle('product_metric_vali'), evaluate_by: @entangle('evaluate_by'), step: @entangle('step'), selected_form: @entangle('selected_form'),  }">
    <form class="flex flex-col gap-4">
        <section class="flex gap-2 mt-4 flex-col">
            <h3 class="text-xl font-bold underline">
                Market Metrics: Step {{ $step + 1 }}
            </h3>
            <p class="p-2 w-full" :class="{'text-red-500':!valid_molecule,'text-green-500':valid_molecule}">
                {{ $valid_molecule ? $search : "Select A Valid Molecule" }}
            </p>
            <p class="p-2 w-full text-green-500">
                {{ $selected_form }}
            </p>
            <div class="flex flex-wrap gap-1 items-center">
                {{-- <p>Selected Strengths: <span class="text-red-500">{{ $selected_strengths ? '' : 'None'  }}</span></p> --}}
                @foreach ($selected_strengths as $strength)
                    <span class="bg-gray-200 text-xs text-green-600 font-bold p-1 rounded">
                        {{ $strength }}
                    </span>
                @endforeach
            </div>
            {{-- Step 0 Start --}}
            <div x-data="{this_step: 0}" x-cloak x-show="step===this_step">
                <input
                    type="text"
                    list="searchList"
                    placeholder="Search Molecules..."
                    wire:model="search"
                    class="border border-gray-400 p-2 w-full rounded"
                />
                <datalist id="searchList">
                    @foreach ($searchList as $item)
                        <option value="{{ $item }}">
                    @endforeach
                </datalist>
            </div>
            {{-- Step 0 End --}}
            {{-- Step 1 Start --}}
            <div x-data="{this_step: 1}" x-cloak x-show="step===this_step">
                <select wire:change="get_strengths" wire:model="selected_form"
                    class="border border-gray-400 p-2 w-full rounded"
                    :class="{'border-red-500':!valid_molecule,'border-green-500':valid_molecule}"
                >
                    <option selected disabled value="">Select A Form</option>
                    @foreach ($forms as $form)
                        <option value="{{ $form }}">{{ $form }}</option>
                    @endforeach
                </select>
            </div>
            {{-- Step 1 End --}}
            {{-- Step 2 Start --}}
            <div class="p-2" x-data="{this_step: 2, local_selected: @entangle('selected_strengths').defer, strengths: @entangle('strengths')}" x-cloak x-show="step===this_step">
                <h3 class="text-xl">Strengths</h3>
                <div class="flex flex-wrap h-fit max-h-48 bg-gray-100 rounded overflow-y-auto">
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
            {{-- Step 2 End --}}
            {{-- Step 3 Start --}}
            <div x-data="{this_step:3}" :disabled="step>this_step" x-cloak x-show="step>=this_step">
                <select wire:change="autofill" wire:model="evaluate_by" class="border border-gray-400 p-2 w-full rounded">
                    <option disabled selected value="">Select Eaches/Units</option>
                    <option value="Eaches">Eaches</option>
                    <option value="Units">Units</option>
                </select>
            </div>
            {{-- Step 3 End --}}
            <div>
                <p class="p-2 w-full text-green-500">
                    {{ $brand_generic}}
                </p>
                <p class="p-2 w-full text-green-500">
                    {{ $category }}
                </p>
                <p class="p-2 w-full flex flex-wrap gap-1 text-green-500">
                    @foreach ($products as $product)
                        <span class="bg-gray-200 text-xs text-green-600 font-bold p-1 rounded">
                            {{ $product }}
                        </span>
                    @endforeach
                </p>
            </div>
        </section>
        <section x-cloak x-show="step===4" class="flex gap-2 mt-4 flex-col">
            <p>Saved Market Metrics. Please fill Product Metrics</p>
            <h3 class="text-xl font-bold underline">
                Product Metrics
            </h3>
            <input type="date" wire:change.defer="vali" wire:model="launch_date" min="{{ date('Y-m-d') }}"
                class="border border-gray-400 p-2 w-full rounded"
            >
            <input wire:change.defer="vali" type="number" wire:model="expected_competitors"
                class="border border-gray-400 p-2 w-full rounded"
                placeholder="Expected Competitors"
                min="0"
            >
            <input type="number" wire:change.defer="vali" wire:model="order_of_entry"
                class="border border-gray-400 p-2 w-full rounded"
                min="1"
                placeholder="Order of Entry"
            >
            <input type="number" wire:change.defer="vali" wire:model="cogs"
                min="0" max="100" step="0.01"
                class="border border-gray-400 p-2 w-full rounded"
                placeholder="COGS (in %)"
            >
            <input type="number" wire:change.defer="vali" wire:model="development_cost"
                class="border border-gray-400 p-2 w-full rounded"
                placeholder="Development Cost"
            >
        </section>
        <p x-show="step===5">Product Metrics Saved</p>
    </form>
    <button :disabled="step===0" wire:click="previous_step" class="bg-green-500 p-2 rounded text-white">
        Previous
    </button>
    <button :disabled=
        "(step===3&&evaluate_by==='')||
        (step===4&&!product_metric_vali)||
        !valid_molecule||
        (step===1&&selected_form==='')"
        wire:click="next_step" class="bg-green-500 p-2 rounded text-white">
        Next
    </button>
</div>
