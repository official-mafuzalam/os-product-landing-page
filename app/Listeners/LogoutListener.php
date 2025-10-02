<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Cache;

class LogoutListener
{
    public function handle(Logout $event)
    {
        Cache::forget('user-is-online-' . $event->user->id);
    }
}