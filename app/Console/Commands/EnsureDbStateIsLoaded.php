<?php

namespace App\Console\Commands;

use Database\State\EnsureUsersArePresent;
use Illuminate\Console\Command;

class EnsureDbStateIsLoaded extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ensure-db-state-is-loaded';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ensure DB state is loaded';

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
        collect(
            [
                new EnsureUsersArePresent
            ]
        )->each->__invoke();
    }
}
