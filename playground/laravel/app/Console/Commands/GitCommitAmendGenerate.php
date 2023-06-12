<?php

namespace app\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class GitCommitAmendGenerate extends Command
{
//    php artisan command:gitCommitAmendGenerate

    protected $signature = 'command:gitCommitAmendGenerate {--amount=} {--date=}';

    protected $secondMin = 5;

//    8 hours
    protected $secondMax = 28800;

    public function handle()
    {
        $date = $this->option('date') ?? Carbon::yesterday()->format('Y-m-d');
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            $this->error('date format is not Y-m-d');
            return;
        }

        $amount = $this->option('amount') ?? 20;
        $results = [];
        for ($i = 0; $i < $amount; $i++) {
            $second = rand($this->secondMin, $this->secondMax);
            $results[] = Carbon::parse($date)->addSeconds($second);
        }

        usort($results, function ($a, $b) {
            return $a->isAfter($b);
        });

        foreach ($results as $result) {
            $dateFormat = $result->format('D M d H:i:s Y');
            $this->line(
                'git commit --amend --date="' . $dateFormat . ' +0800" --no-edit && GIT_COMMITTER_DATE="' . $dateFormat . ' +0800" git commit --amend --no-edit'
            );
        }
    }
}
