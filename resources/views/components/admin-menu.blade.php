@php
    use App\Filament\Resources\Shield\RoleResource;
    use App\Filament\Resources\TenantResource;
    use App\Filament\Resources\UserResource;
    use Spatie\Permission\Models\Role;
    use App\Models\Tenant;
    use App\Models\User;
@endphp

@if (Filament\Facades\Filament::getTenant() != null && (
        auth()->user()->can('viewAny', User::class) ||
        auth()->user()->can('viewAny', Role::class) ||
        auth()->user()->can('viewAny', Tenant::class)))

    <x-filament::dropdown placement="bottom-end" :teleport="true">
        
        <x-slot name="trigger">
            <button class='flex flex-shrink-0 items-center justify-center text-primary-500 hover:text-primary-900 hover:bg-primary-500 dark:hover:bg-primary-500'>
                <x-filament::icon alias="filament-quick-create::bolt" icon="heroicon-o-rocket-launch" class="w-7 h-7" />
            </button>
        </x-slot>

        <x-filament::dropdown.list>
            {{-- Users --}}
            @can('viewAny', User::class)
                <x-filament::dropdown.list.item icon="heroicon-o-users" :href="UserResource::getUrl()" tag="a">
                    {{ __('Users') }}
                </x-filament::dropdown.list.item>
            @endcan

            {{-- Roles --}}
            @can('viewAny', Role::class)
                <x-filament::dropdown.list.item icon="heroicon-o-shield-check" :href="RoleResource::getUrl()" tag="a">
                    {{ __('Roles') }}
                </x-filament::dropdown.list.item>
            @endcan

            {{-- Tenants --}}
            @can('viewAny', Tenant::class)
                <x-filament::dropdown.list.item icon="heroicon-o-building-office-2" :href="TenantResource::getUrl()" tag="a">
                    {{ __('Tenants') }}
                </x-filament::dropdown.list.item>
            @endcan
        </x-filament::dropdown.list>

    </x-filament::dropdown>

@endif
