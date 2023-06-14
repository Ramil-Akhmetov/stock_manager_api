<?php

namespace App\Listeners;

use App\Events\RoomEvent;
use App\Models\Responsibility;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UpdateResponsibilityListener
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
    public function handle(RoomEvent $event): void
    {
        $this->{$event->method}($event);
    }

    private function store(RoomEvent $event): void
    {
        Responsibility::create([
            'user_id' => $event->room->user_id,
            'room_id' => $event->room->id,
        ]);
    }

    private function update(RoomEvent $event): void
    {
        if($event->old_user_id === $event->room->user_id) {
            return;
        }
        //todo debug this, sometimes didn't work
        $responsibility = Responsibility::where('user_id', $event->room->user_id)
            ->where('room_id', $event->room->id)
            ->where('end_date', null)
            ->first();
        $responsibility->update([
            'end_date' => Carbon::now()->toDateString(),
            'user_id' => $event->room->user_id,
            'room_id' => $event->room->id,
        ]);
    }
}
