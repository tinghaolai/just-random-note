<?php

namespace app\Console\Commands;

use Illuminate\Console\Command;

class MarkdownAPI extends Command
{
    protected $signature = 'command:markdownAPI';

    public function handle()
    {
        $description = "login api";
        $method = "POST";
        $path = "/login";
        $inputs = [
            [
                "type" => "string",
                "name" => "username",
                "required" => "true",
                "description" => "username",
            ],
            [
                "type" => "string",
                "name" => "password",
                "required" => "true",
                "description" => "password",
            ],
        ];

        $response = [
            [
                "type" => "string",
                "name" => "token",
            ]
        ];

        $markdown =
"# $description
## Method $method
## Path $path

## Inputs
| Type | Name | Required | Description |
| :--- | :--- | :--- | :--- |
";

foreach ($inputs as $input) {
$markdown .= "| {$input['type']} | {$input['name']} | {$input['required']} | {$input['description']} |
";
}

$markdown .= "

## Response

| Type | Name |
| :--- | :--- |
";

        foreach ($response as $res) {
            $markdown .= "| {$res['type']} | {$res['name']} |
";
        }

        $this->info($markdown);
        // write markdown to file: ./markdown-api-result.md
        file_put_contents('./markdown-api-result.md', '');
        file_put_contents('./markdown-api-result.md', $markdown, LOCK_EX);
    }
}
