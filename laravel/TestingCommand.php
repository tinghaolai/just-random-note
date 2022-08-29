<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
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
        $this->setConnection();
        $this->createDatabase();
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
                $table->string('member_id');
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

    public function bulkCreateMember($bulkNum = 10)
    {
        $bulk = [];
        for ($i = 0; $i < $bulkNum; $i++) {
            $bulk[] = $this->getMemberData();
        }

        DB::table('members')->insert($bulk);
    }

    public function getMemberData()
    {
        return [
            'member_id' => 'memberId',
            'name'      => 'memberId',
            'gender'    => 'male',
        ];
    }

    public function generateCsv()
    {
        $fp = fopen('exampleCsv-10.csv', 'w');

        fputs($fp, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
        fputcsv($fp, [
            'member_id',
            'gender',
            'name'
        ]);

        for ($i = 1; $i < 10; $i ++) {
            $this->line($i);
            fputs($fp, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
            fputcsv($fp, [
                'memberId' . $i,
                'gender' . $i,
                'name' . $i
            ]);
        }

        fclose($fp);
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

        $this->compareSingleCreateAndBulkInsert();
    }
}
