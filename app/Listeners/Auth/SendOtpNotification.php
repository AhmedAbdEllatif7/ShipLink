<?php

namespace App\Listeners\Auth;

use App\Events\Auth\OtpRequested;
use App\Notifications\Auth\PreRegistrationOtpNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendOtpNotification implements ShouldQueue
{
    use InteractsWithQueue;

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
    public function handle(OtpRequested $event): void
    {
        Notification::route('mail', $event->email)
            ->notify(new PreRegistrationOtpNotification($event->code));
    }
}
