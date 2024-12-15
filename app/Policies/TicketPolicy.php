<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    /**
     * Determine whether the user can view the ticket.
     *
     * Admins can view all tickets, while customers can only view their own tickets.
     */
    public function view($user, Ticket $ticket): bool
    {
        if ($user instanceof Admin) {
            return true; // Admins can view all tickets
        }

        return $ticket->customer_id === $user->id; // Customers can only view their own tickets
    }

    /**
     * Determine whether the user can create a ticket.
     *
     * Only customers are allowed to create tickets.
     */
    public function create($user): bool
    {
        return $user instanceof Customer; // Only customers can create tickets
    }

    /**
     * Determine whether the user can update (reply to) the ticket.
     *
     * Only admins can reply to or update the status of tickets.
     */
    public function update($user, Ticket $ticket): bool
    {
        return $user instanceof Admin; // Only admins can reply to or update tickets
    }

    /**
     * Determine whether the user can delete the ticket.
     *
     * Only admins can delete any ticket.
     * Customers can only delete their own tickets.
     */
    public function delete($user, Ticket $ticket): bool
    {
        return $user instanceof Admin; // Admins can delete any ticket
    }
}
