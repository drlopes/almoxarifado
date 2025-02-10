<x-filament-panels::page>

    {{-- TABLE CONTAINER --}}
    <div class="w-full flex flex-col" style="margin-top: 3px;">
        <div class="flex justify-between items-center mb-3">

            <div class="flex justify-start items-center gap-x-3">

                {{-- searchbar --}}
                <x-filament::input.wrapper prefix-icon="heroicon-m-magnifying-glass">
                    <x-filament::input type="text" wire:model.live="search" wire:submit="$refresh"
                        placeholder="{{ __('Search...') }}" />

                    <x-slot name="prefix">
                        <x-filament::input.select wire:model.live="searchBy">
                            @foreach (self::getModel()::getSearchableFields(forHumans: true) as $field => $name)
                                <option value="{{ $field }}">
                                    {{ $name }}
                                </option>
                            @endforeach
                        </x-filament::input.select>
                    </x-slot>

                </x-filament::input.wrapper>
            </div>

            <div class="flex justify-end items-center gap-x-4">

                {{-- clear filters --}}
                @if ($this->search || $this->searchBy || $this->step || $this->state || $this->start_date || $this->end_date)
                    {{ $this->clearFilterAction }}
                @endif

                {{-- filter dropdown --}}
                <x-filament::dropdown placement="bottom-start">
                    <x-slot name="trigger">
                        <x-filament::icon-button icon="heroicon-o-funnel" size="xl" />
                    </x-slot>

                    <x-filament::dropdown.list>
                        <x-filament::dropdown.list.item class="cursor-default" color="info">

                            {{-- step filter --}}
                            <span class="text-gray-500 dark:text-gray-400 text-md">
                                {{ __('Step') }}
                            </span>
                            <div class="ring-1 ring-inset ring-gray-300 dark:ring-gray-700 rounded-md">
                                <x-filament::input.select wire:model.live="step">

                                    <option value="0">
                                        {{ __('Any') }}
                                    </option>

                                    @for ($i = 1; $i <= self::getModel()::getStepCount(); $i++)
                                        <option value="{{ $i }}">
                                            {{ self::getModel()::getLegend()[self::getModel()::getStepNames()[$i - 1]] }}
                                        </option>
                                    @endfor

                                </x-filament::input.select>
                            </div>

                        </x-filament::dropdown.list.item>

                        <x-filament::dropdown.list.item class="cursor-default" color="info">

                            {{-- state filter --}}
                            <span class="text-gray-500 dark:text-gray-400 text-md">
                                {{ __('State') }}
                            </span>

                            <div class="ring-1 ring-inset ring-gray-300 dark:ring-gray-700 rounded-md">
                                <x-filament::input.select wire:model.live="state">

                                    <option value="all">{{ __('Any') }}</option>
                                    <option value="paused">{{ __('Paused') }}</option>
                                    <option value="completed">{{ __('Completed') }}</option>
                                    <option value="in-progress">{{ __('In Progress') }}</option>

                                </x-filament::input.select>
                            </div>

                        </x-filament::dropdown.list.item>

                        <x-filament::dropdown.list.item class="cursor-default" color="info">

                            {{-- start date filter --}}
                            <span class="text-gray-500 dark:text-gray-400 text-md">
                                {{ __('Created from') }}
                            </span>

                            <div class="ring-1 ring-inset ring-gray-300 dark:ring-gray-700 rounded-md">
                                <x-filament::input type="date" wire:model.live="start_date" />
                            </div>

                        </x-filament::dropdown.list.item>

                        <x-filament::dropdown.list.item class="cursor-default" color="info">

                            {{-- end date filter --}}
                            <span class="text-gray-500 dark:text-gray-400 text-md">
                                {{ __('Created until') }}
                            </span>

                            <div class="ring-1 ring-inset ring-gray-300 dark:ring-gray-700 rounded-md">
                                <x-filament::input type="date" wire:model.live="end_date" />
                            </div>
                        </x-filament::dropdown.list.item>
                    </x-filament::dropdown.list>
                </x-filament::dropdown>
            </div>

        </div>

        @if ($stockWriteOffs->count() >= 1)
            <div class="flex items-start justify-center min-h-56 select-none">
                <table
                    class="divide-y divide-gray-200 dark:divide-gray-800 mb-2 w-full border-t border-gray-200 dark:border-gray-800 table-fixed"
                    lazy>
                    <thead>
                        <tr>
                            <th class="w-6 text-center"></th>

                            <th
                                class="py-3 text-left ps-3 text-sm font-medium text-gray-500 uppercase tracking-wider w-32">
                                {{ __('CODE') }}
                            </th>

                            @for ($i = 0; $i < $steps; $i++)
                                <th
                                    class="py-3 px-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    {{ $stepNames[$i] }}
                                </th>
                            @endfor

                            <th
                                class="py-3 text-center text-sm font-medium text-gray-500 uppercase tracking-wider w-16">
                                {{ __('END') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stockWriteOffs as $stockWriteOff)
                            <tr wire:key="{{ $stockWriteOff->id }}">
                                <td class="py-5 whitespace-nowrap">
                                    <div class="w-full h-full flex items-center justify-center">
                                        <livewire:stock-write-offs.row-actions :key="'record-' . $stockWriteOff->id . '-actions'" :record="$stockWriteOff" />
                                    </div>
                                </td>

                                <td class="py-5 whitespace-nowrap">
                                    <div class="text-xs text-gray-900 select-text text-center">
                                        {{ $stockWriteOff->code }}
                                    </div>
                                </td>

                                @for ($i = 1; $i <= $steps; $i++)
                                    <td class="py-5 whitespace-nowrap select-none border-none m-0 px-0"
                                        wire:key="{{ $stockWriteOff->id }}-{{ $i }}">

                                        @if ($stockWriteOff->current_step >= $i)
                                            @if ($stockWriteOff->steps["step_{$i}"]['filled'])
                                                <livewire:stock-write-offs.step-filled lazy :key="'record-' . $stockWriteOff->id . '-step-' . $i . '-filled'"
                                                    :record="$stockWriteOff" :step='$stockWriteOff->steps["step_{$i}"]' />
                                            @else
                                                <livewire:stock-write-offs.step-pending lazy :key="'record-' . $stockWriteOff->id . '-step-' . $i . '-pending'"
                                                    :record="$stockWriteOff" :step='$stockWriteOff->steps["step_{$i}"]' />
                                            @endif
                                        @else
                                            <livewire:stock-write-offs.step-locked lazy :key="'record-' . $stockWriteOff->id . '-step-' . $i . '-locked'"
                                                :record="$stockWriteOff" />
                                        @endif

                                    </td>
                                @endfor

                                <td class="py-5 whitespace-nowrap">
                                    <div class="w-full h-full flex items-center justify-center">
                                        @if ($stockWriteOff->current_step <= self::getModel()::getStepCount())
                                            <livewire:stock-write-offs.stock-write-off-in-progress lazy
                                                :key="'record-' . $stockWriteOff->id . '-in-progress'" :record="$stockWriteOff" />
                                        @else
                                            @if ($stockWriteOff->is_closed)
                                                <livewire:stock-write-offs.stock-write-off-closed lazy
                                                    :key="'record-' . $stockWriteOff->id . '-closed'" :record="$stockWriteOff" />
                                            @else
                                                <livewire:stock-write-offs.stock-write-off-done lazy :key="'record-' . $stockWriteOff->id . '-done'"
                                                    :record="$stockWriteOff" />
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            {{-- EMPTY STATE --}}
            <div class="flex items-center justify-center h-56">
                <div class="text-center flex flex-col items-center gap-4">
                    <div class="text-gray-500 dark:text-gray-400">
                        <x-filament::icon icon="heroicon-m-face-frown" wire:target="search"
                            class="h-10 w-10 text-gray-400 dark:text-gray-400" />
                    </div>
                    <div class="text-lg text-gray-400 dark:text-gray-400">
                        {{ __('No record found') }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- PAGINATION --}}
    <x-filament::pagination :paginator="$stockWriteOffs" extreme-links :page-options="[3, 5, 10, 20, 50, 100]"
        current-page-option-property="perPage" />

    {{-- TABLE LEGEND --}}
    <div class="flex justify-start gap-4 mt-4">
        @foreach (self::getModel()::getLegend() as $label => $legend)
            <div class="flex items-center gap-1 text-xs">
                <span class="text-gray-900 dark:text-gray-400">
                    {{ $label }}:
                </span>

                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                    {{ $legend }}
                </div>
            </div>
        @endforeach
    </div>

</x-filament-panels::page>
