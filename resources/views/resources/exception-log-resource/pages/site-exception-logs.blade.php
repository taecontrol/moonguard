<x-filament::page>
    <div class="grid grid-cols-1 gap-4 xl:grid-cols-3">
        <div>
            <label class="text-sm text-gray-600 dark:text-gray-400">Status</label>
            <x-moonguard::dropdown placeholder="Status filter" :options="$this->exceptionLogStatusFilterOptions" wire:model="exceptionLogStatusFilter" x-on:change="$dispatch('input', $event.target.value)" x-on:input="$wire.filterByStatus($event.detail)"/>
        </div>
        <div></div>
        <div>
            @if ($exceptions->count() > 0)
                <label class="text-sm text-gray-600 dark:text-gray-400">Update exceptions status as</label>
                <div class="flex justify-between space-x-2">
                    <div class="flex-1">
                        <x-moonguard::dropdown placeholder="Status" :options="$this->exceptionLogStatusFilterOptions" wire:model="allExceptionStatusAs" />
                    </div>
                    <div wire:click="updateAllExceptionLogStatus">
                        <x-filament::button class="w-full">
                            Update
                        </x-filament::button>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <x-moonguard::exception-list :exceptions="$exceptions" />
</x-filament::page>
