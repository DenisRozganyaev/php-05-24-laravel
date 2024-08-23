<?php

namespace App\Policies\Api;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     * index action
     */
    public function viewAny(User $user): bool
    {
        return $user->tokenCan('read') || $user->tokenCan('full');
    }

    /**
     * Determine whether the user can view the model.
     * show action
     */
    public function view(User $user, Product $product): bool
    {
        return $user->tokenCan('read') || $user->tokenCan('full');
    }

    /**
     * Determine whether the user can create models.
     * store action
     */
    public function create(User $user): bool
    {
        return $user->tokenCan('full');
    }

    /**
     * Determine whether the user can update the model.
     * update
     */
    public function update(User $user, Product $product): bool
    {
        return $user->tokenCan('full');
    }

    /**
     * Determine whether the user can delete the model.
     * delete
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->tokenCan('full');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product): bool
    {
        return $user->tokenCan('full');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        return $user->tokenCan('full');
    }
}
