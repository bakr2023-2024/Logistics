<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Customer;

class CustomerPolicy
{
    /**
     * Determine whether the user can view the customer.
     *
     * Both admins and customers can view any other customer.
     * Since this action doesn't have any restrictions, it will always return true.
     */
    public function view($user, Customer $customer): bool
    {
        return $user instanceof Admin || $user->id === $customer->id; // Admins and customers can view any customer
    }

    /**
     * Determine whether the user can update the customer.
     *
     * Only the customer themselves can update their own details.
     * Admins can update any customer.
     */
    public function update($user, Customer $customer): bool
    {
        return $user instanceof Admin || $user->id === $customer->id;
    }

    /**
     * Determine whether the user can delete the customer.
     *
     * Only the customer themselves can delete their own account.
     * Admins can delete any customer.
     */
    public function delete($user, Customer $customer): bool
    {
        return $user instanceof Admin || $user->id === $customer->id; // Admins can delete any customer, customers can only delete themselves
    }
}
