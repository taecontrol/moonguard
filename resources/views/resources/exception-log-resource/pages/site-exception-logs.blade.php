<x-filament::page>
    <div class="grid xl:grid-cols-3 grid-cols-1 gap-4">
        <div>
            <label class="text-gray-600 text-sm">Status</label>
            <x-moonguard::dropdown placeholder="Status filter" :options="$this->exceptionLogStatusFilterOptions" wire:model="exceptionLogStatusFilter" />
        </div>
        <div></div>
        <div>
            @if ($exceptions->count() > 0)
                <label class="text-gray-600 text-sm">Update exceptions status as</label>
                <div class="w-full flex justify-between">
                    <div class="w-full">
                        <x-moonguard::dropdown placeholder="Status" :options="$this->exceptionLogStatusFilterOptions" wire:model="allExceptionStatusAs" />
                    </div>
                    <div class="ml-2" wire:click="updateAllExceptionLogStatus">
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
