<div>
    <form x-data="{ valid_molecule: @entangle('valid_molecule') }" class="flex flex-col gap-4">
        <section class="flex gap-2 mt-4 flex-col">
            <h3 class="text-xl font-bold underline">
                Market Metriks
            </h3>
            <input 
                wire:change="get_dose_forms"
                type="text"
                list="searchList"
                placeholder="Search Molecules..."
                wire:model="search"
                class="border border-gray-400 p-2 w-full rounded"
            />
            <p class="p-2 w-full" :class="{'text-red-500':!valid_molecule,'text-green-500':valid_molecule}">
                {{ $valid_molecule ? $search : "Select A Valid Molecule" }}
            </p>
            <datalist id="searchList">
                @foreach ($searchList as $item)
                    <option value="{{ $item }}">
                @endforeach
            </datalist>
            <select wire:change="get_strengths" wire:model="selected_form"
                class="border border-gray-400 p-2 w-full rounded"
                :class="{'border-red-500':!valid_molecule,'border-green-500':valid_molecule}"
            >
                <option selected value="">Select A Form</option>
                @foreach ($forms as $form)
                    <option value="{{ $form }}">{{ $form }}</option>
                @endforeach
            </select>
            <div class="p-2">
                <h3 class="text-xl">Strengths</h3>
                <div class="flex flex-wrap gap-1 items-center">
                    <p>Selected Strengths: <span class="text-red-500">{{ $selected_strengths ? '' : 'None'  }}</span></p>
                    @foreach ($selected_strengths as $strength)
                        <span class="bg-gray-200 text-xs text-green-600 font-bold p-1 rounded">
                            {{ $strength }}
                        </span>
                    @endforeach
                </div>
                <div class="flex flex-wrap h-fit max-h-48 bg-gray-100 rounded overflow-y-auto">
                    @foreach ($strengths as $strength)
                        <label class="bg-gray-200 p-2 m-2 rounded cursor-pointer" 
                            for="{{ $strength }}">
                            <input wire:change="autofill"
                                type="checkbox" wire:model="selected_strengths"
                                value="{{ $strength }}"
                                id="{{ $strength }}"
                            >
                            {{ $strength }}
                        </label>
                    @endforeach
                </div>
            </div>
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
            <select wire:model="units_eaches" class="border border-gray-400 p-2 w-full rounded">
                <option selected value="">Select Eaches/Units</option>
                    <option value="Eaches">Eaches</option>
                    <option value="Units">Units</option>
            </select>
        </section>
        <section class="flex gap-2 mt-4 flex-col">
            <h3 class="text-xl font-bold underline">
                Produkt Metriks
            </h3>
            <input type="date" wire:model="launch_date" min="{{ date('Y-m-d') }}"
                class="border border-gray-400 p-2 w-full rounded"
            >
            <input type="number" wire:model="expected_competitors"
                class="border border-gray-400 p-2 w-full rounded"
                placeholder="Expected Competitors"
                min="0"
            >
            <input type="number" wire:model="order_of_entry"
                class="border border-gray-400 p-2 w-full rounded"
                min="1"
                placeholder="Order of Entry"
            >
            <input type="number" wire:model="cogs"
                min="0" max="100" step="0.01"
                class="border border-gray-400 p-2 w-full rounded"
                placeholder="COGS (in %)"
            >
            <input type="number" wire:model="development_cost"
                class="border border-gray-400 p-2 w-full rounded"
                placeholder="Development Cost"
            >
        </section>
    </form>
</div>
