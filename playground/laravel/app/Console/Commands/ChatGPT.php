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
        $needTranslateContent = file_get_contents('./translate.md');

        $data = [
            'model' => $model,
            'messages' => [
                [
                    'role' => 'user',
                    'content' => "請幫我把以下的英文 markdown 文章
                        翻譯成繁體中文

                        $needTranslateContent

                    ",
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
            $translated = json_decode($body, true)['choices'][0]['message']['content'];
            $hugoFlagPrefix = "<!--HugoNoteFlag-->

---

";

            $i18nPrefix = "

---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

";

            $result = print_r($hugoFlagPrefix . $needTranslateContent . $i18nPrefix . $translated, true);
            echo $result;

            $filePath = 'translated.md';
            file_put_contents($filePath, '');
            file_put_contents($filePath, $result, LOCK_EX);
        } else {
            $body = $response->body();
            echo $body;
        }
    }
}
