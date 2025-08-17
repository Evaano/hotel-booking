<?php

namespace App\Console\Commands;

use App\Models\BeachEvent;
use Illuminate\Console\Command;

class ExpireEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark past beach events as completed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Find events that have ended and are still active
        $pastEvents = BeachEvent::where('status', 'active')
            ->where(function ($query) {
                $query->where('event_date', '<', now()->toDateString())
                    ->orWhere(function ($q) {
                        $q->where('event_date', '=', now()->toDateString())
                            ->whereRaw("event_date || ' ' || end_time < ?", [now()]);
                    });
            })
            ->get();

        $count = $pastEvents->count();

        if ($count > 0) {
            $pastEvents->each(function ($event) {
                $event->update(['status' => 'completed']);
                $this->info("Completed: {$event->name} ({$event->event_date})");
            });

            $this->info("Marked {$count} past events as completed.");
        } else {
            $this->info('No events to expire.');
        }

        return 0;
    }
}
