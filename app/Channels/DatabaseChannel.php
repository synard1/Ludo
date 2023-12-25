<?php
namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Channels\DatabaseChannel as IlluminateDatabaseChannel;

class DatabaseChannel extends IlluminateDatabaseChannel
{
    /**
    * Send the given notification.
    *
    * @param mixed $notifiable
    * @param \Illuminate\Notifications\Notification $notification
    * @return \Illuminate\Database\Eloquent\Model
    */
    public function send($notifiable, Notification $notification)
    {
        return $notifiable->routeNotificationFor('database')->create([
            'id'      => $notification->id,
            'type'    => get_class($notification),
            'user_cid'=> $notification->user_cid ?? null,
            'user_id'=> $notification->user_id ?? null,
            'created_by'=> $notification->created_by ?? null,
            'created_by_level'=> $notification->created_by_level ?? null,
            'data'    => $this->getData($notifiable, $notification),
            'read_at' => null,
        ]);
    }
}