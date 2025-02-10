<?php

namespace App\Models;

use App\Models\User;
use Filament\Models\Contracts\HasCurrentTenantLabel;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model implements HasName, HasCurrentTenantLabel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'client',
        'description',
    ];

    /***
     * Get the users that belong to the tenant.
     */
    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get the name of the tenant for display.
     */
    public function getFilamentName() : string
    {
        return strtoupper($this->code);
    }

    /**
     * Get the label for the current tenant.
     */
    public function getCurrentTenantLabel() : string
    {
        return __('Tenant');
    }

    protected function code() : Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtolower($value),
        );
    }
}
