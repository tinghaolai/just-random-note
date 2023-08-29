<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CommandFeatures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:command-features';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->table(
            ['Name', 'Email'],
            [
                ['John Doe', 'emailA',],
                ['Jane Doe', 'emailB'],
            ]
        );

        $data = range(1, 5);
        $bar = $this->output->createProgressBar(count($data));
        $bar->start();

        foreach ($data as $num) {
            $this->line('num: ' . $num);
            sleep(1);
            $bar->advance();
        }

        $bar->finish();
    }
}
