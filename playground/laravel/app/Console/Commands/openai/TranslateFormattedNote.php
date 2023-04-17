<?php

namespace app\Console\Commands\openai;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TranslateFormattedNote extends Command
{
    protected $signature = 'command:translateFormattedNote';

    public function handle()
    {
        $apiKey = env('OPENAI_API_KEY');
        $model = 'gpt-3.5-turbo';
        $url = 'https://api.openai.com/v1/chat/completions';
//        $filePath = 'aws/nginx-reset-after-ec2-restart.md';
        $filePath = $this->ask('Please note file path');
        $basePath = '../../';
        $fullPath = $basePath . $filePath;
        $noteContent = file_get_contents($fullPath);
        $pattern = '/(!--HugoNoteFlag-->\n\n---\n\n)(.*)(---\n\n<!--HugoNoteZhFlag--)/s';
        preg_match($pattern, $noteContent, $matches, PREG_OFFSET_CAPTURE);
        if (count($matches) === 0) {
            $this->line('Note format error');
            return;
        }

        $noteContent = $matches[2][0];

        $data = [
            'model' => $model,
            'messages' => [
                [
                    'role' => 'user',
                    'content' => "請幫我把以下的英文 markdown 文章
                        翻譯成繁體中文

                        $noteContent

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

            $result = print_r($hugoFlagPrefix . $noteContent . $i18nPrefix . $translated, true);
            file_put_contents($fullPath, '');
            file_put_contents($fullPath, $result, LOCK_EX);
        } else {
            $body = $response->body();
            echo $body;
        }
    }
}
