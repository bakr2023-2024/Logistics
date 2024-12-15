<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Customer;
use Illuminate\Auth\Access\Response;

class AdminPolicy
{ //
    public function view($user, Admin $admin): bool
    {
        return $user instanceof Admin;
    }

    /**
     * Determine whether the user can create models.
     */
    public function update($user, Admin $admin): bool
    {
        return $user instanceof Admin;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Admin $admin): bool
    {
        return $user instanceof Admin;
    }
}
