<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePmTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('statistic_tasks')) {
            if (! Schema::hasColumn('statistic_tasks', 'pm_task_id')) {
                Schema::table('statistic_tasks', function (Blueprint $table) {
                    $table->integer('pm_task_id')->nullable(true)->default(null);
                    $table->unique(['employe_id','pm_task_id','date'], 'IDX_UNIQUE_STATS');
                });
            }
        }
        if (Schema::hasTable('plan_tasks')) {
            if (! Schema::hasColumn('plan_tasks', 'pm_task_id')) {
                Schema::table('plan_tasks', function (Blueprint $table) {
                    $table->integer('pm_task_id')->nullable(true)->default(null);
                    $table->unique(['employe_id','pm_task_id','date'], 'IDX_UNIQUE_STATS');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
