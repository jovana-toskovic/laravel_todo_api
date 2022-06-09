<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\NotifyUserAboutDoneTasks;
use DateTimeZone;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class SendDoneTasksNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $midnightTimezones = [];
        $date = now()->format('Y-m-d H:i');

        foreach(DateTimeZone::listIdentifiers() as $timezone) {
            $formatedDate = (Carbon::createFromFormat('Y-m-d H:i', $date))->setTimezone($timezone)->format('H:i');
            if($formatedDate >= '00:00' && $formatedDate <= '01:00') {
                $midnightTimezones[] = $timezone;
            }
        }

        $yesterday =  Carbon::createFromFormat('Y-m-d H:i', $date)->subDay();
        $users = User::with(['tasks', 'lists', 'lists.tasks' => function($query) use ($yesterday){
                $query
                    ->wherePivot('done', '>=', $yesterday->startOfDay()->format('Y-m-d H:i'))
                    ->wherePivot('done', '<=', $yesterday->endOfDay()->format('Y-m-d H:i'));
            }])
            ->whereIn('timezone', $midnightTimezones)
            ->get();

        foreach ($users as $user) {
            $message = '';
            if(!empty($user->lists)) {
                foreach ($user->lists as $list) {
                    if(!empty($list->tasks)) {
                        $message .= " List $list->title: " . count($list->tasks);
                    }
                }
            }

            if($message) {
                $user->notify(new NotifyUserAboutDoneTasks($message));
            }
        }

    }
}
