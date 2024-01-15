<?php

namespace App\Console\Commands;

use App\Models\Encounter;
use Carbon\Carbon;

use Illuminate\Console\Command;

class UpdateEncounterStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'encounters:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update encounter status based on certain conditions';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $encounters = Encounter::where('status', '!=', 3)
            ->where('created_at', '<=', Carbon::now()->subHours(24))
            ->get();


        foreach ($encounters as $encounter) {
            $encounter->update(['status' => 3]);
        }

        $this->info('Encounter status updated successfully.');
    }
}
