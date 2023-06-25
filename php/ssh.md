<!--HugoNoteFlag-->

---

Simple example to execute ssh command in PHP

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use phpseclib3\Net\SSH2;
use phpseclib3\Crypt\PublicKeyLoader;

class SendCommandController extends Controller
{
    public function __invoke(Request $request)
    {
        $host = config('ssh.host');
        $port = config('ssh.port');
        $username = config('ssh.username');
        $keyPassword = config('ssh.keyPassword');

        $key = PublicKeyLoader::load(
            Storage::get('ssh_key'),
            $keyPassword
        );

        $ssh = new SSH2($host, $port);
        if (!$ssh->login($username, $key)) {
            throw new \Exception('Login failed');
        }

        $output = $ssh->exec($request->command);

        return response()->json($output);
    }
}


```

---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

在 PHP 中執行 SSH 命令的簡單示例

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use phpseclib3\Net\SSH2;
use phpseclib3\Crypt\PublicKeyLoader;

class SendCommandController extends Controller
{
    public function __invoke(Request $request)
    {
        $host = config('ssh.host');
        $port = config('ssh.port');
        $username = config('ssh.username');
        $keyPassword = config('ssh.keyPassword');

        $key = PublicKeyLoader::load(
            Storage::get('ssh_key'),
            $keyPassword
        );

        $ssh = new SSH2($host, $port);
        if (!$ssh->login($username, $key)) {
            throw new \Exception('登錄失敗');
        }

        $output = $ssh->exec($request->command);

        return response()->json($output);
    }
}


```