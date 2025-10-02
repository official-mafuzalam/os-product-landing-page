<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        // Use caching for better performance
        return Cache::rememberForever('setting_' . $key, function () use ($key, $default) {
            return Setting::getValue($key, $default);
        });
    }
}

if (!function_exists('fb_event_id')) {
    function fb_event_id()
    {
        return uniqid('fb_', true);
    }
}


if (!function_exists('setMailConfigFromDB')) {
    function setMailConfigFromDB()
    {
        Config::set('mail.default', setting('mail_mailer', 'smtp'));
        Config::set('mail.mailers.smtp.host', setting('mail_host', 'smtp.mailtrap.io'));
        Config::set('mail.mailers.smtp.port', setting('mail_port', 587));
        Config::set('mail.mailers.smtp.username', setting('mail_username'));
        Config::set('mail.mailers.smtp.password', setting('mail_password'));
        Config::set('mail.mailers.smtp.encryption', setting('mail_encryption', 'tls'));
        Config::set('mail.from.address', setting('mail_from_address', 'hello@example.com'));
        Config::set('mail.from.name', setting('mail_from_name', config('app.name')));
    }
}