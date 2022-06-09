<?php

namespace App\Console\Commands;

use App\Jobs\SendDoneTasksNotificationJob;
use App\Models\TodoList;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SendDoneTasksNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:done-tasks-notification {--date=}';

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
        $date = Carbon::createFromFormat('Y-m-d h-i', $this->option('date') ?? now()->subDay()->format('Y-m-d h-i-0'));

        SendDoneTasksNotificationJob::dispatch($date);
    }
}
