<?php

// crontab -e
// enter `*/5 * * * * /usr/bin/php /app/health-check/check.php`

$targetUrl = '';
$targetPath = '/api/v1/app/version';
$lineGroupId = '';
$lineChannelAccessToken = '';

$healthChecker = new ApiHealthChecker($targetUrl);
$apiResult = $healthChecker->get($targetPath);
$validateResult = $healthChecker->validateResult($apiResult);

$lineBotClient = new LineBotClient($lineGroupId, $lineChannelAccessToken);
if ($validateResult) {
    $lineBotClient->messagePush('Govel API is OK');
} else {
    $lineBotClient->messagePush('!!!!!!!!!!!!!!!!!!!!GovelWarning!!!!!!!!!!!!!!!!!!!!!!!!!!!!  Govel API is not OK');
}


class ApiHealthChecker
{
    private string $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function get($path)
    {
        $ch = curl_init($this->url . $path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    public function validateResult($result): bool
    {
        return !empty($result['latestVersion']);
    }
}

class LineBotClient
{
    private string $groupId;
    private string $channelAccessToken;

    public function __construct(
        $groupId,
        $channelAccessToken
    )
    {
        $this->groupId = $groupId;
        $this->channelAccessToken = $channelAccessToken;
    }

    public function messagePush($message)
    {
        $post_data = [
            'to' => $this->groupId,
            'messages' => [
                [
                    'type' => 'text',
                    'text' => $message
                ]
            ]
        ];

        $ch = curl_init('https://api.line.me/v2/bot/message/push');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->channelAccessToken
        ));
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
