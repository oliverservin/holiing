<?php

namespace App\Livewire;

trait InteractsWithNotifications
{
    protected function notify($message)
    {
        $this->dispatch('notify',
            content: $message,
            type: 'success'
        );
    }

    protected function notifyError($message)
    {
        $this->dispatch('notify',
            content: $message,
            type: 'error'
        );
    }
}
