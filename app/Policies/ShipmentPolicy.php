<?php

namespace App\Policies;

use App\Models\Shipment;
use App\Models\Admin;
use App\Models\Customer;

class ShipmentPolicy
{
    /**
     * Determine if the user can view the shipment.
     */
    public function view($user, Shipment $shipment): bool
    {
        if ($user instanceof Admin) {
            return true; // Admin can view all shipments
        }

        return $shipment->customer_id === $user->id; // Customers can only view their shipments
    }

    /**
     * Determine if the user can create shipments.
     */
    public function create($user): bool
    {
        return $user instanceof Customer; // Only customers can create shipments
    }

    /**
     * Determine if the user can update the shipment.
     */
    public function update($user, Shipment $shipment): bool
    {
        return $user instanceof Admin; // Only admins can update shipments
    }

    /**
     * Determine if the user can delete the shipment.
     */
    public function delete($user, Shipment $shipment): bool
    {
        return $user instanceof Admin; // Only admins can delete shipments
    }
}
