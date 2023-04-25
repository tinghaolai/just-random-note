<?php

namespace app\Console\Commands\openai;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class AskAnyThing extends Command
{
    protected $signature = 'ask';

    public function handle()
    {
        $apiKey = env('OPENAI_API_KEY');
        $model = 'gpt-3.5-turbo';
        $url = 'https://api.openai.com/v1/chat/completions';
        $askContent = file_get_contents('./ask-gpt.md');

        $data = [
            'model' => $model,
            'messages' => [
                [
                    'role' => 'user',
                    'content' => "$askContent",
                ]
            ],
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $apiKey,
        ])->withOptions([
            'verify' => false,
            'timeout' => 600,
        ])
        ->post($url, $data);

        if ($response->successful()) {
            $body = $response->body();
            $askResult = json_decode($body, true)['choices'][0]['message']['content'];

            $filePath = './ask-gpt-result.md';
            file_put_contents($filePath, '');
            file_put_contents($filePath, $askResult);
        } else {
            $body = $response->body();
            echo $body;
        }
    }
}
