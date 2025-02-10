<?php

namespace App\Models;

use Filament\Panel;
use App\Models\Tenant;
use App\Observers\UserObserver;
use Illuminate\Support\Collection;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\HasTenants;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasDefaultTenant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Yebor974\Filament\RenewPassword\Traits\RenewPassword;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;
use Yebor974\Filament\RenewPassword\Contracts\RenewPasswordContract;

class User extends Authenticatable implements HasTenants, HasDefaultTenant, FilamentUser, RenewPasswordContract
{
    use HasFactory, Notifiable, HasRoles, TwoFactorAuthenticatable, RenewPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'preferences',
        'latest_tenant_id',
        'force_renew_password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $with = [
        'tenants',
        'latestTenant',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts() : array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'preferences' => 'array',
        ];
    }

    /**
     * Get the tenants that the user belongs to.
     */
    public function tenants() : BelongsToMany
    {
        return $this->belongsToMany(Tenant::class);
    }

    /**
     * Get the tenants that the user belongs to.
     */
    public function getTenants(Panel $panel) : Collection
    {
        return $this->tenants;
    }

    /**
     * Determine if the user can access the given tenant.
     */
    public function canAccessTenant(Model $tenant) : bool
    {
        return $this->tenants()->whereKey($tenant)->exists();
    }

    public function getDefaultTenant(Panel $panel) : ?Model
    {
        return $this->latestTenant;
    }

    public function latestTenant() : BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'latest_tenant_id');
    }

    public function canBeImpersonated()
    {
        return ! $this->hasRole('developer');
    }

    public function canImpersonate()
    {
        return $this->hasRole('developer');
    }

    public function canAccessPanel(Panel $panel) : bool
    {
        return true;
    }
}
