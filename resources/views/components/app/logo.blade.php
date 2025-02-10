@php
    use Filament\Facades\Filament;
@endphp

@if (Filament::getTenant() != null)
    <div class="flex items-center space-x-2">
        @if (Filament::getTenant()->code == 'cddnpc' ||
                Filament::getTenant()->code == 'fbdnpc' ||
                Filament::getTenant()->code == 'fbdlnpc' ||
                Filament::getTenant()->code == 'cddnpa')
            <img src="{{ asset('/tenants/danone.svg') }}" alt="Logo" class="h-12 dark:bg-white p-1 rounded-lg">
        @endif
    </div>
@else
    <div class="flex items-center space-x-2">
        <img src="{{ asset('/logo.svg') }}" alt="Logo" class="h-10">
    </div>
@endif
