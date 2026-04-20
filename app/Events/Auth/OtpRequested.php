<?php

namespace App\Events\Auth;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OtpRequested
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $email;
    public $code;

    /**
     * Create a new event instance.
     */
    public function __construct(string $email, string $code)
    {
        $this->email = $email;
        $this->code = $code;
    }
}
