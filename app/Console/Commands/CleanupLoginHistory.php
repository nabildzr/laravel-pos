<?php

namespace App\Console\Commands;

use App\Models\LoginHistory;
use Illuminate\Console\Command;

class CleanupLoginHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'login-history:cleanup {--days=30}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup old login history records';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $date = now()->subDays($days);

        $count = LoginHistory::where('created_at', '<', $date)->delete();

        $this->info("Deleted {$count} old login history records.");
    }
}
