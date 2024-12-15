<?php

namespace App\Providers;

use App\Models\Log;
use App\Providers\ActivityLogged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogActivity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ActivityLogged $event): void
    {
        Log::create([
            'activity_type' => $event->activityType->value,
            'description' => $event->description,
            'created_at' => now(),
        ]);
    }
}
