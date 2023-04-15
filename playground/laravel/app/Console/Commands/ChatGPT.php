<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ChatGPT extends Command
{
    protected $signature = 'command:chatgpt';

    public function handle()
    {
        $apiKey = env('OPENAI_API_KEY');
        $model = 'gpt-3.5-turbo';
        $url = 'https://api.openai.com/v1/chat/completions';

        $data = [
            'model' => $model,
            'messages' => [
                [
                    'role' => 'user',
                    'content' => '請幫我把以下的英文 markdown 文章
                        翻譯成繁體中文

                        Testing context, and i am a dog

                    ',
                ]
            ],
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $apiKey,
        ])->withOptions([
            'verify' => false,
        ])
        ->post($url, $data);

        if ($response->successful()) {
            $body = $response->body();
            echo print_r(json_decode($body, true)['choices'][0]['message']['content'], true);
        } else {
            $body = $response->body();
            echo $body;
        }
    }
}
