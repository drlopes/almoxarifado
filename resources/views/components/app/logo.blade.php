@php
    use Filament\Facades\Filament;
@endphp

@if (Filament::getTenant() != null)
    <div class="flex items-center">
        <x-filament::icon
            class="h-10 w-10 text-gray-500 dark:text-gray-400"
            icon="heroicon-o-book-open" />
    </div>
@else
    <div>
        <x-filament::icon
            class="h-10 w-10 text-gray-500 dark:text-gray-400"
            icon="heroicon-o-book-open" />
    </div>
@endif
