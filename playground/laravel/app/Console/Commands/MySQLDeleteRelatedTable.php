<?php

namespace App\Console\Commands;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


/**
 * test_type_without_id_type_index
 *
 * ---deleteFromWhereIn start---
run time: 41.261170148849seconds
---deleteFromWhereIn end----
---deleteFroWhereExists start---
run time: 41.044189929962seconds
---deleteFroWhereExists end----
---deleteFromJoin start---
run time: 42.302510023117seconds
---deleteFromJoin end----

 *
 *
 */

/**
 *
 * test_type_with_id_type_index
 *
 * ---deleteFromWhereIn start---
run time: 41.456815004349seconds
---deleteFromWhereIn end----
---deleteFroWhereExists start---
run time: 42.01546216011seconds
---deleteFroWhereExists end----
---deleteFromJoin start---
run time: 39.968888044357seconds
---deleteFromJoin end----

 *
 */

/**
 * test_type_with_id_type_index_and_force_index
 *
 * ---deleteFromWhereIn start---
run time: 44.467664003372seconds
---deleteFromWhereIn end----
---deleteFroWhereExists start---
run time: 39.107469081879seconds
---deleteFroWhereExists end----
---deleteFromJoin start---
run time: 62.701831102371seconds
---deleteFromJoin end----

 */


class MySQLDeleteRelatedTable extends TestingCommand
{
    protected $signature = 'command:mySQLDeleteRelatedTable';

    protected $description = 'Command description';

    public function handle()
    {
//        $this->test_type_without_id_type_index();
//        $this->test_type_with_id_type_index();
        $this->test_type_with_id_type_index_and_force_index();
    }

    public function test_type_without_id_type_index()
    {
        $this->line('test_type_without_id_type_index');
        $this->createTables(true);
        $this->insertTagTable(2000, 2500);
        $this->insertTagRelationTable(2000, 2500);
        $this->cloneTagRelationTable('delete_related_table_member_tag_where_in');
        $this->cloneTagRelationTable('delete_related_table_member_tag_where_exists');
        $this->cloneTagRelationTable('delete_related_table_member_tag_where_join');
        $this->deleteFromWhereIn('delete_related_table_member_tag_where_in');
        $this->deleteFroWhereExists('delete_related_table_member_tag_where_exists');
        $this->deleteFromJoin('delete_related_table_member_tag_where_join');
    }

    public function test_type_with_id_type_index()
    {
        $this->line('test_type_with_id_type_index');
        $this->createTables(true, true);
        $this->insertTagTable(2000, 2500);
        $this->insertTagRelationTable(2000, 2500);
        $this->cloneTagRelationTable('delete_related_table_member_tag_where_in');
        $this->cloneTagRelationTable('delete_related_table_member_tag_where_exists');
        $this->cloneTagRelationTable('delete_related_table_member_tag_where_join');
        $this->deleteFromWhereIn('delete_related_table_member_tag_where_in');
        $this->deleteFroWhereExists('delete_related_table_member_tag_where_exists');
        $this->deleteFromJoin('delete_related_table_member_tag_where_join');
    }

    public function test_type_with_id_type_index_and_force_index()
    {
        $this->line('test_type_with_id_type_index_and_force_index');
        $this->createTables(true, true);
        $this->insertTagTable(2000, 2500);
        $this->insertTagRelationTable(2000, 2500);
        $this->cloneTagRelationTable('delete_related_table_member_tag_where_in');
        $this->cloneTagRelationTable('delete_related_table_member_tag_where_exists');
        $this->cloneTagRelationTable('delete_related_table_member_tag_where_join');
        $this->deleteFromWhereIn('delete_related_table_member_tag_where_in', true);
        $this->deleteFroWhereExists('delete_related_table_member_tag_where_exists', true);
        $this->deleteFromJoin('delete_related_table_member_tag_where_join', true);
    }

    public function cloneTagRelationTable($tableName)
    {
        $this->line('clone table: ' . $tableName);
        Schema::dropIfExists($tableName);
        DB::statement("CREATE TABLE $tableName
            AS SELECT * FROM delete_related_table_member_tags;
        ");
    }

    public function createTables($forceRecreate = false, $idTypeIndex = false)
    {
        if ($forceRecreate) {
            $this->line('dropping tables');
            Schema::dropIfExists('delete_related_table_tags');
            Schema::dropIfExists('delete_related_table_member_tags');
        }

        if (!Schema::hasTable('delete_related_table_tags')) {
            Schema::create('delete_related_table_tags', function (Blueprint $table) use ($idTypeIndex) {
                $table->increments('id');
                $table->string('type')->index('type');
                if ($idTypeIndex) {
                    $table->index(['id', 'type'], 'id_type_index');
                }
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('delete_related_table_member_tags')) {
            Schema::create('delete_related_table_member_tags', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('tag_id')->index('tag_id');
                $table->unsignedInteger('member_id');
                $table->timestamps();
            });
        }
    }

    public function insertTagTable($chunkNumber, $chunkTime)
    {
        DB::table('delete_related_table_tags')->truncate();
        $this->line('start inert tag table');
        $data = [];
        for ($i = 0; $i < $chunkNumber; $i++) {
            $type = match ($i % 3) {
                2 => 'A',
                1 => 'B',
                default => 'C',
            };

            $data[] = ['type' => $type];
        }

        for ($i = 0; $i < $chunkTime; $i++) {
            DB::table('delete_related_table_tags')->insert($data);
        }
    }

    public function insertTagRelationTable($chunkNumber, $chunkTime)
    {
        DB::table('delete_related_table_member_tags')->truncate();
        $this->line('start inert tag relation table');

        for ($i = 0; $i < $chunkTime; $i++) {
            $data = [];
            for ($j = 1; $j <= $chunkNumber; $j++) {
                $data[] = [
                    'tag_id' => $i * $chunkNumber + $j,
                    'member_id' => $j,
                ];
            }

            DB::table('delete_related_table_member_tags')->insert($data);
        }
    }

    public function deleteFromWhereIn($tableName, $forceIndex = false)
    {
        $forceIndex = $forceIndex ? 'force index (id_type_index)' : '';
        $delete = function () use ($tableName, $forceIndex) {
            DB::statement("
                delete from $tableName relation where tag_id in
                    (select id from delete_related_table_tags tag $forceIndex where tag.type = 'A');
            ");
        };

        $this->timeRecord($delete, 'deleteFromWhereIn');
    }

    public function deleteFroWhereExists($tableName, $forceIndex = false)
    {
        $forceIndex = $forceIndex ? 'force index (id_type_index)' : '';
        $delete = function () use ($tableName, $forceIndex) {
            DB::statement("
                delete from $tableName relation
                where exists(select id from delete_related_table_tags tag $forceIndex where tag.id = relation.tag_id and tag.type = 'A');
            ");
        };

        $this->timeRecord($delete, 'deleteFroWhereExists');
    }

    public function deleteFromJoin($tableName, $forceIndex = false)
    {
        $forceIndex = $forceIndex ? 'force index (id_type_index)' : '';
        $delete = function () use ($tableName, $forceIndex) {
            DB::statement("
                delete relation from $tableName relation
                inner join delete_related_table_tags tag $forceIndex on relation.tag_id = tag.id
                where tag.type = 'A';
            ");
        };

        $this->timeRecord($delete, 'deleteFromJoin');
    }
}
