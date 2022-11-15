<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class TestingCommand extends Command
{
    protected $signature = 'command:testingCommand';
    protected $description = '';
    public function __construct()
    {
        parent::__construct();
    }

    public function laravel_password()
    {
        $password = 'yourPassword';
//      DB value
        dd($hashed = bcrypt($password));

//      Verify
        dd(password_verify($password, $hashed));
    }

    public function haveToRun()
    {
        $this->setConnection();
    }

    public function setConnection()
    {
        DB::disconnect('mysql');
        DB::purge('mysql');
        Config::set('database.connections.mysql.database', 'test');
    }

    public function dbRelatedCreate()
    {
        $this->createDatabase();
        $this->setConnection();
        $this->createMemberTable();
    }

    public function createDatabase()
    {
        $dbName    = 'test';
        $charset   = 'utf8mb4';
        $collation = 'utf8mb4_unicode_ci';
        $query     = "CREATE DATABASE IF NOT EXISTS $dbName CHARACTER SET $charset COLLATE $collation;";

        DB::statement($query);
    }

    public function createMemberData()
    {
        DB::table('members')->insert($this->getMemberData());
    }

    public function createMemberTable()
    {
        if (!Schema::connection('mysql')->hasTable('members')) {
            Schema::connection('mysql')->create('members', function (Blueprint $table) {
                $table->increments('id');
                $table->string('member_id')->index('member_id');
                $table->integer('type')->index('type');
                $table->integer('status')->index('status');
                $table->string('name', 50);
                $table->string('gender', 50);
                $table->timestamps();
            });
        }
    }

    public function timeRecord(\Closure $function, $functionName = 'time record')
    {
        $this->line("---$functionName start---");
        $timeStart = microtime(true);
        $function();
        $this->line('run time: ' . (microtime(true) - $timeStart) . 'seconds');
        $this->line("---$functionName end----");
    }

    public function bulkCreateMember($bulkNum = 2000, $bulkTimes = 2000)
    {
        $bulk = [];
        for ($j = 0; $j < $bulkNum; $j++) {
            $bulk[] = $this->getMemberData();
        }

        for ($i = 0; $i < $bulkTimes; $i++) {
            $this->line('bulk batch: ' . $i);
            DB::table('members')->insert($bulk);
            sleep(1);
        }
    }

    public function getMemberData()
    {
        return [
            'member_id' => 'memberId',
            'name'      => 'memberId',
            'gender'    => 'male',
        ];
    }

    public function compareSingleCreateAndBulkInsert()
    {
//        $amount = 10000

//    ---multi create start---
//    run time: 78.605982065201seconds
//    ---multi create end----
//     ---bulk create start---
//    run time: 0.17566990852356seconds
//    ---bulk create end----

        $amount = 10000;
        $runMultiCreate = function () use ($amount) {
            for ($i = 0; $i < $amount; $i++) {
                $this->createMemberData();
            }
        };

        $bulkCreate = function () use ($amount) {
            $this->bulkCreateMember($amount);
        };

        $this->timeRecord($runMultiCreate, 'multi create');
        $this->timeRecord($bulkCreate, 'bulk create');
    }

    public function writeCsv()
    {
        $fp = fopen('test-csv.csv', 'w');

        fputs($fp, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
        fputcsv($fp, [
            'memberIds',
            'city',
            'level'
        ]);

        $category = ['taipei', 'Kao', 'tap'];
        $tags = ['level1', 'level2', 'level3', 'level4'];

        for ($i = 1; $i <= 100; $i ++) {
            $this->line($i);
            fputs($fp, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
            fputcsv($fp, [
                'MEM' . rand(500000, 90000000),
                $category[rand(0,2)],
                $tags[rand(0, 3)]
            ]);
        }

        fclose($fp);
    }

    public function testEmpty()
    {
        $test = [
            'a' => null,
            'b' => 0,
            'c' => '',
        ];

        dd(
            empty($test['a']),
            empty($test['b']),
            empty($test['c'])
        );
    }

    public function logMemoryUsage($value = 'default')
    {
        Log::info(
            $value . ': ' .
            number_format(
                (memory_get_usage() / 1024 / 1024),
                2,
                '.',
                ''
            ). 'M'
        );
    }

    public function curlCvs()
    {
        $fileName     = 'customer-cv.csv';
        $uploadApiUrl = 'api-url...';
        $apiToken     = 'enter your token here';
        $header       = ["Content-type:multipart/form-data", "Accept:application/json", "Api-Key:$apiToken"];
        $curl         = curl_init();
        $fields       = [
            'importCsv'  => new \CurlFile($fileName, 'text/csv', $fileName),
            'insertType' => 'insertIgnoreExist',
            'existType'  => 'existTag',
        ];

        curl_setopt($curl, CURLOPT_URL, $uploadApiUrl);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($curl);
        curl_close($curl);

        dd($result);
    }

    public function readCsv()
    {
        $total = [
            '2022-01' => 0,
            '2022-02' => 0,
            '2022-03' => 0,
            '2022-04' => 0,
            '2022-05' => 0,
            '2022-06' => 0,
            '2022-07' => 0,
            '2022-08' => 0,
            '2022-09' => 0,
        ];

        for ($i = 1; $i<= 60; $i++) {
            if ($i == 16 ) {
                continue;
            }

            if (($handle = fopen("csv/test-$i.csv", "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $this->line(json_encode($data));
                    $total[$data[2]] += $data[3];
                }

                fclose($handle);
            }
        }

        dd($total);
    }

    public function logQuery(Callable $function)
    {
        $connection = 'connection';
        DB::connection($connection)->enableQueryLog();
        $function();
        $queries = DB::connection($connection)->getQueryLog();
        dd($queries);

//        or...
//        paste in app/Providers/AppServiceProvider
//        public function register()
//    {
//        \DB::listen(function ($query) {
//            $sql = $query->sql;
//            $bindings = $query->bindings;
//            $executionTime = $query->time;
//            \Log::info('query', [$sql, $bindings]);
//        });
    }

    public function logExecuteTime(Callable $function, $executeName = '')
    {
        $timeStart = microtime(true);

        $function();

        $this->line(($executeName ? ($executeName . ' - ') : '') .
            'execute time: ' . (microtime(true) - $timeStart) . ' seconds');
    }

    public function memberBuilder()
    {
        return DB::table('members');
    }

    /**
     * Execute result stored in file "compareDataFetchingResult.md"
     *
     * @return void
     */
    public function compareDataFetching()
    {
        $this->line('---------- normal fetch check ----------');
        $this->logExecuteTime($this->getMemberChunk(1000), 'fetch table 1000');
        $this->logExecuteTime($this->getMemberChunk(1000, 'chunkById'), 'fetch table by id 1000');
        $this->logExecuteTime($this->getMemberChunk(5000, 'chunkById'), 'fetch table by id 5000');
        $this->logExecuteTime($this->getMemberChunk(10000, 'chunkById'), 'fetch table by id 10000');

        $this->line('---------- start condition check ----------');

        $builder = $this->memberBuilder()
            ->select('members.id')
            ->where('member_id', 'memberId')
            ->where('type', 0)
            ->where('name', '%memberId%')
            ->where('gender', '%male%');

        $this->logExecuteTime($this->getMemberChunk(1000, 'chunk', $builder), 'Chunk 1000');
        $this->logExecuteTime($this->getMemberChunk(1000, 'chunkById', $builder), 'ChunkById 1000');
        $this->logExecuteTime($this->getMemberChunk(5000, 'chunkById', $builder), 'ChunkById 5000');
        $this->logExecuteTime($this->getMemberChunk(10000, 'chunkById', $builder), 'ChunkById 10000');

        $this->logExecuteTime($this->getMemberFromTempTable(), 'create form sub table');

        dd('done');
    }

    public function compareDataFetching_complex_version()
    {
        $this->line('compareDataFetching_complex_version');

        $builder = $this->memberBuilder()
            ->select('members.id')
            ->join( 'members as m2', DB::raw( 'm2.id'), '=', DB::raw( 'members.id'))
            ->where('m2.member_id', 'like', '%memberId%')
            ->where('m2.type', 0)
            ->where('m2.name', 'like', '%memberId%')
            ->where('m2.gender', 'like', '%male%');

//        $this->logExecuteTime($this->getMemberChunk(3000, 'chunkById', $builder), 'ChunkById 3000');
//        $this->logExecuteTime($this->getMemberChunk(10000, 'chunkById', $builder), 'ChunkById 10000');
        $this->logExecuteTime($this->getMemberFromTempTable(), 'create form sub table');

        dd('done');
    }

    public function getMemberFromTempTable($ifComplex = false)
    {
        return function () use ($ifComplex) {
            DB::statement('DROP TABLE IF EXISTS temp_members');
            if (!$ifComplex) {
                $tempCreate = function () {
                    DB::statement(
                        "create table temp_members (
                        id int(11) not null AUTO_INCREMENT,
                        member_id varchar(255) NULL,
                        type varchar(255) NULL,
                        status varchar(255) NULL,
                        name varchar(255) NULL,
                        gender varchar(255) NULL,
                        created_at timestamp,
                        updated_at timestamp,

                        PRIMARY KEY (id)
                    )
                    select `id`,
                           `member_id`,
                           `type`,
                           `status`,
                           `name`,
                           `gender`,
                           `created_at`,
                           `updated_at`
                           from `members`
                    where member_id = 'memberId'
                    and type = 0
                    and status = 0
                    and name = 'memberId'
                    and gender = 'male'"
                    );};
            } else {
                $tempCreate = function () {
                    DB::statement(
                        "create table temp_members (
                        id int(11) not null AUTO_INCREMENT,
                        member_id varchar(255) NULL,
                        type varchar(255) NULL,
                        status varchar(255) NULL,
                        name varchar(255) NULL,
                        gender varchar(255) NULL,
                        created_at timestamp,
                        updated_at timestamp,

                        PRIMARY KEY (id)
                    )
                    select t1.id,
                           t1.member_id,
                           t1.type,
                           t1.status,
                           t1.name,
                           t1.gender,
                           t1.created_at,
                           t1.updated_at from test.members t1
                               join test.members m2 on m2.member_id = t1.member_id
                    where m2.member_id like '%memberId%'
                    and m2.type = 0
                    and m2.name like '%memberId%'
                    and m2.gender like '%male%';"
                    );};
            }

            $this->logExecuteTime($tempCreate, 'create temp member table');

            $everyFetchLogCount = 3000;
            $timeStart = microtime(true);
            DB::table('temp_members')->orderBy('id')->chunkById(
                $everyFetchLogCount,
                function ($members) use ($everyFetchLogCount, &$timeStart) {
                    $this->line('fetch ' . $everyFetchLogCount . ' row, count time: ' .
                        (microtime(true) - $timeStart) . ' seconds');
                    $timeStart = microtime(true);
                });
        };
    }

    public function getMemberChunk($chunkNum = 2000, $chunkFunction = 'chunk', $builder = null)
    {
        if (is_null($builder)) {
            $builder = $this->memberBuilder();
        }

        return function () use ($chunkNum, $chunkFunction, $builder) {
            $everyFetchLogCount = 3000;
            $nextCount = $everyFetchLogCount;
            $timeStart = microtime(true);
            return $builder->orderBy('members.id')
                ->$chunkFunction($chunkNum, function ($members) use ($everyFetchLogCount, &$nextCount, &$timeStart) {
                    if ($members->last()->id >= $nextCount) {
                        $this->line('fetch ' . $everyFetchLogCount . ' row, count time: ' .
                            (microtime(true) - $timeStart) . ' seconds');

                        $timeStart = microtime(true);
                        $nextCount += $everyFetchLogCount;
                    }
                }, 'members.id', 'id');
        };
    }

    public function handle()
    {
//  ------dont comment---------
        $this->haveToRun();
//  ------dont comment---------

//        $this->laravel_password();
//        $this->dbRelatedCreate();
//        $closure = function () {
//            $this->createMemberData();
//        };
//
//        $this->timeRecord($closure);
    }
}
