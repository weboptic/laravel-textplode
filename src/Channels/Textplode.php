<?php

namespace Weboptic\Textplode\Channels;

use Illuminate\Notifications\Notification;

class Textplode
{
    public function send($notifiable, Notification $notification)
    {
        if (config('app.env') === 'local') {
            return;
        }

        $recipient = null;
        $message = null;

        if (method_exists($notifiable, 'routeNotificationForSms')) {
            $recipient = $notifiable->routeNotificationForSms($notification);
        } elseif (method_exists($notifiable, 'routeNotificationForTextplode')) {
            $recipient = $notifiable->routeNotificationForTextplode($notification);
        }

        if (! $recipient) {
            return;
        }

        if (method_exists($notification, 'toSms')) {
            $message = $notification->toSms($notifiable)->addRecipient($recipient);
        } elseif (method_exists($notification, 'toTextplode')) {
            $message = $notification->toTextplode($notifiable)->addRecipient($recipient);
        }

        if (! $message) {
            return;
        }

        $from_name = config('services.textplode.from', config('app.name'));

        $message->from($from_name);
        $message->send();
    }
}
