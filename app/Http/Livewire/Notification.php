<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Notification extends Component
{
    // public function render()
    // {
    //     return view('livewire.notification');
    // }
    public function render()
    {
        $notifications = auth()->user()->notifications;

        return view('livewire.notification', ['notifications' => $notifications]);
    }
}
