<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->role === 'admin' || $authUser->hasRole('admin');
    }

    public function view(AuthUser $authUser, Role $role): bool
    {
        return $authUser->role === 'admin' || $authUser->hasRole('admin');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->role === 'admin' || $authUser->hasRole('admin');
    }

    public function update(AuthUser $authUser, Role $role): bool
    {
        return $authUser->role === 'admin' || $authUser->hasRole('admin');
    }

    public function delete(AuthUser $authUser, Role $role): bool
    {
        return $authUser->role === 'admin' || $authUser->hasRole('admin');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->role === 'admin' || $authUser->hasRole('admin');
    }

    public function restore(AuthUser $authUser, Role $role): bool
    {
        return $authUser->can('Restore:Role');
    }

    public function forceDelete(AuthUser $authUser, Role $role): bool
    {
        return $authUser->can('ForceDelete:Role');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Role');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Role');
    }

    public function replicate(AuthUser $authUser, Role $role): bool
    {
        return $authUser->can('Replicate:Role');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Role');
    }
}
