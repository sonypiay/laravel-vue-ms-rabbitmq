<?php

namespace App\Console\Commands;

use App\Jobs\TestJob;
use Illuminate\Console\Command;

class FireEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fire-event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fire event';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        TestJob::dispatch();
    }
}
