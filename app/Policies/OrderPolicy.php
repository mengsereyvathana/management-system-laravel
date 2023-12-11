<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    private string $modelName = 'orders';
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if($user->hasPermissionTo('view '. $this->modelName)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order): bool
    {
        if($user->hasPermissionTo('view '. $this->modelName)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
//    public function create(User $user): bool
//    {
//        if($user->hasPermissionTo('create '. $this->modelName)){
//            return true;
//        }
//        return false;
//    }

    /**
     * Determine whether the user can update the model.
     */
//    public function update(User $user, Order $order): bool
//    {
//        if($user->hasPermissionTo('update '. $this->modelName)){
//            return true;
//        }
//        return false;
//    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Order $order): bool
    {
        if($user->hasPermissionTo('delete '. $this->modelName)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Order $order): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Order $order): bool
    {
        //
    }
}
