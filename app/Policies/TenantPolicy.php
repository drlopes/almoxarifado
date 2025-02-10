<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class TenantPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user) : bool
    {
        return $user->can('view_any_tenant');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Tenant $tenant) : bool
    {
        return $user->can('view_tenant') && $user->tenants->contains($tenant);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user) : bool
    {
        return $user->can('create_tenant');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Tenant $tenant) : bool
    {
        return $user->can('update_tenant') && $user->tenants->contains($tenant);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Tenant $tenant) : bool
    {
        return $user->can('delete_tenant') && $user->tenants->contains($tenant);
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user) : bool
    {
        return $user->can('delete_any_tenant');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Tenant $tenant) : bool
    {
        return $user->can('force_delete_tenant') && $user->tenants->contains($tenant);
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user) : bool
    {
        return $user->can('force_delete_any_tenant') && $user->hasRole('developer');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Tenant $tenant) : bool
    {
        return $user->can('restore_tenant') && $user->tenants->contains($tenant);
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user) : bool
    {
        return $user->can('restore_any_tenant');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Tenant $tenant) : bool
    {
        return $user->can('replicate_tenant') && $user->tenants->contains($tenant);
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user) : bool
    {
        return $user->can('reorder_tenant');
    }

    public function detach(User $user, Tenant $tenant, Model $owner) : bool
    {
        if ($owner->hasRole('developer') && $user->id != $owner->id) {
            return false;
        }

        if (! $user->tenants->contains($tenant)) {
            return false;
        }

        if ($user->tenants()->count() <= 1) {
            return false;
        }

        if ($tenant->id === auth()->user()->latestTenant->id && $owner->id === $user->id) {
            return false;
        }

        return true;
    }
}
