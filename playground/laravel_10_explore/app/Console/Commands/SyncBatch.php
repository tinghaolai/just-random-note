<?php

namespace App\Console\Commands;

use Illuminate\Bus\Batch;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Console\Command;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class SyncBatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-batch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run in QUEUE_CONNECTION=sync';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Bus::batch([
            new PrimaryJob,
            new PrimaryJob,
        ])->then(function (Batch $batch) {
            Log::info('batch then');
        })->name('Import Contacts')->dispatch();
    }
}

class PrimaryJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public function handle(): void
    {
        if ($this->batch()->cancelled()) {
            return;
        }

        Log::info('PrimaryJob');
        foreach (range(1, 10) as $i) {
            SecondaryJob::dispatch();
            sleep(2);
        }
    }
}

class SecondaryJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public function handle(): void
    {
        Log::info('SecondaryJob');
    }
}
