<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Encounter;
use App\Constants;

class MissingVisits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'missing-visits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Encounter::where('created_at', '<=', now()->subHour())
            ->where('status', 2)
            ->whereNull('arrived_at')
            ->update(['status' => 4]);

        $this->info('Your custom command has run successfully!');
    }
}
