<?php

namespace App\Console\Commands;

use App\Jobs\SendDoneTasksNotificationJob;
use Illuminate\Console\Command;

class SendDoneTasksNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:done-tasks-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send done tasks notification.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        SendDoneTasksNotificationJob::dispatch();
    }
}
