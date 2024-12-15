<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->enum('activity_type', [
                'customer_login',
                'customer_logout',
                'admin_login',
                'admin_logout',
                'admin_password_reset',
                'customer_password_reset',
                'customer_created',
                'customer_updated',
                'customer_deleted',
                'admin_created',
                'admin_updated',
                'admin_deleted',
                'shipment_created',
                'shipment_updated',
                'shipment_deleted',
                'ticket_created',
                'ticket_updated',
                'ticket_deleted',
            ]);
            $table->text('description'); // Details of the activity
            $table->timestamps(); // Log created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
