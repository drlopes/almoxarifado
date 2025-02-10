<x-filament-panels::page>

    <div x-data="@js([
        'activeTab' => $code === null ? 'general' : 'record',
    ])">

        <div class="flex justify-start items-center mb-4 gap-x-4 border-b border-gray-200 dark:border-gray-700 pb-3">
            <button x-on:click="activeTab = 'general'"
                class="p-2 rounded-lg ring-1 ring-gray-200 dark:ring-gray-800 flex items-center gap-x-2"
                :class="{ 'bg-gray-100 dark:bg-gray-800': activeTab === 'general' }">

                <span class="h-5 w-5 text-gray-500 dark:text-gray-400" :class="{'text-primary-600 dark:text-primary-400': activeTab === 'general'}">
                    <x-filament::icon
                    alias="panels::topbar.global-search.field"
                    icon="heroicon-o-globe-alt"
                    wire:target="search"
                    class="h-5 w-5" />
                </span>

                <span class="text-gray-500 dark:text-gray-400"
                    :class="{ 'text-primary-600 dark:text-primary-400': activeTab === 'general' }">
                    {{ __('General') }}
                </span>
            </button>

            <button x-on:click="activeTab = 'record'"
                class="ps-2 h-10 rounded-lg ring-1 ring-gray-200 dark:ring-gray-800 flex items-center gap-x-2"
                :class="{ 'bg-gray-100 dark:bg-gray-800': activeTab === 'record' }">

                <span class="h-5 w-5 text-gray-500 dark:text-gray-400" :class="{'text-primary-600 dark:text-primary-400': activeTab === 'record'}">
                    <x-filament::icon
                    alias="panels::topbar.global-search.field"
                    icon="heroicon-o-rectangle-group"
                    wire:target="search"
                    class="h-5 w-5" />
                </span>

                <div class="flex items-center gap-x-2">
                    <span class="text-gray-500 dark:text-gray-400 pe-2"
                        :class="{ 'text-primary-600 dark:text-primary-400': activeTab === 'record' }">
                        {{ __('Process') }}
                    </span>

                    <div x-show="activeTab === 'record'" class="bg-white dark:bg-gray-900 rounded-lg text-gray-500 dark:text-gray-400">
                        <x-filament::input type="text" wire:model.live="code" placeholder="ABCDE-000000" />
                    </div>
                </div>
            </button>
        </div>

        <div x-show="activeTab === 'general'" class="grid grid-cols-1 gap-4">
            <div>
                @livewire(\App\Filament\Widgets\StockWriteOffsOverview::class)
            </div>

            <div>
                @livewire(\App\Filament\Widgets\DiscardedMaterialsGraph::class)
            </div>
        </div>

        <div x-show="activeTab === 'record'">
            @if ($code !== null)
            
                <livewire:stock-write-offs.record-report :$code />

            @endif
        </div>

    </div>

</x-filament-panels::page>
