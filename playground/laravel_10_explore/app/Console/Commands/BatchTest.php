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

class BatchTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:batch-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run in QUEUE_CONNECTION=database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('start---');
        Bus::batch([
            new BatchTestPrimaryJob,
            new BatchTestPrimaryJob,
        ])->then(function (Batch $batch) {
            Log::info('batch then');
        })->name('Import Contacts')->dispatch();
    }
}

class BatchTestPrimaryJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public function handle(): void
    {
        if ($this->batch()->cancelled()) {
            return;
        }

        Log::info('PrimaryJob');
        foreach (range(1, 10) as $i) {
            $this->batch()->add(new BatchTestSecondaryJob);
        }
    }
}

class BatchTestSecondaryJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public function handle(): void
    {
        sleep(10);
        Log::info('SecondaryJob');
    }
}
