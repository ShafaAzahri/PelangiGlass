<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\GalleryCategory;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class GalleryCategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:GalleryCategory');
    }

    public function view(AuthUser $authUser, GalleryCategory $galleryCategory): bool
    {
        return $authUser->can('View:GalleryCategory');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:GalleryCategory');
    }

    public function update(AuthUser $authUser, GalleryCategory $galleryCategory): bool
    {
        return $authUser->can('Update:GalleryCategory');
    }

    public function delete(AuthUser $authUser, GalleryCategory $galleryCategory): bool
    {
        return $authUser->can('Delete:GalleryCategory');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:GalleryCategory');
    }

    public function restore(AuthUser $authUser, GalleryCategory $galleryCategory): bool
    {
        return $authUser->can('Restore:GalleryCategory');
    }

    public function forceDelete(AuthUser $authUser, GalleryCategory $galleryCategory): bool
    {
        return $authUser->can('ForceDelete:GalleryCategory');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:GalleryCategory');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:GalleryCategory');
    }

    public function replicate(AuthUser $authUser, GalleryCategory $galleryCategory): bool
    {
        return $authUser->can('Replicate:GalleryCategory');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:GalleryCategory');
    }
}
