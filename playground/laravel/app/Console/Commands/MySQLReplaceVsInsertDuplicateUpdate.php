<?php

namespace App\Console\Commands;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


/**
 * Didn't test performance, should be about the same.
 * Mainly because replace will trigger delete casade,
 * so I decide not to use it.
 *
 */
class MySQLReplaceVsInsertDuplicateUpdate extends TestingCommand
{
    protected $signature = 'command:mySQLReplaceVsInsertDuplicateUpdate';
    protected $description = '';

    const MEMBER_TABLE_CASADE = 'replace_vs_duplicate_delete_CASADE_members_CASADE';
    const ORDER_TABLE_CASADE = 'replace_vs_duplicate_delete_CASADE_member_orders_CASADE';

    public function handle()
    {
        $this->createTableOnDeleteCASADE();
        $this->checkIfReplaceTriggerDeleteCASADE();
    }

    public function checkIfReplaceTriggerDeleteCASADE()
    {
        $memberId = DB::table(self::MEMBER_TABLE_CASADE)->insertGetId([
            'name' => 'nameA',
            'type' => 'A',
        ]);

        $orderId = DB::table(self::ORDER_TABLE_CASADE)->insertGetId([
            'member_id' => $memberId,
        ]);

        DB::statement(
            "replace into " . self::MEMBER_TABLE_CASADE . " (name, type) VALUES ('nameA', 'B')"
        );

        $order = DB::table(self::ORDER_TABLE_CASADE)->find($orderId);
        $this->line($order ? 'order found' : 'order not found');
    }

    public function createTableOnDeleteCASADE()
    {
        $this->line('createTableOnDeleteCASADE');
        Schema::dropIfExists(self::ORDER_TABLE_CASADE);
        Schema::dropIfExists(self::MEMBER_TABLE_CASADE);

        Schema::create(self::MEMBER_TABLE_CASADE, function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->index('type');
            $table->string('name')->unique('unique_name');
            $table->timestamps();
        });

        Schema::create(self::ORDER_TABLE_CASADE, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('member_id');
            $table->timestamps();
            $table->foreign('member_id', 'member_foreign')
            ->references('id')
            ->on(self::MEMBER_TABLE_CASADE)
            ->onDelete('cascade');
        });
    }
}
