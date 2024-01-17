<?php

namespace App\Listeners;

use App\Events\AdminRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendAdminRegistrationEmail
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
    public function handle(AdminRegistered $event): void
    {
        //
    }
}
