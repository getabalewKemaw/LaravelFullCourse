<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CleanOldLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * You can run it manually using: php artisan logs:clean
     */
    protected $signature = 'logs:clean';

    /**
     * The console command description.
     */
    protected $description = 'Simulate cleaning old log files and write status to the log.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧹 Starting cleanup process...');

        // Simulate a slow process
        sleep(3);

        // Pretend we cleaned files and log it
        Log::info('Old logs cleaned successfully at: ' . now());

        $this->info('✅ Cleanup done!');
        return self::SUCCESS;
    }
}
