<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePmTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('employes')) {
            Schema::create('employes', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('last_name', 255);
                $table->string('middle_name', 255)->nullable(true)->default(null);
                $table->text('description')->nullable(true)->default(null);
                $table->enum('gender', ['M', 'W'])->default('M');
                $table->date('birthday')->nullable(true)->default(null);
                $table->float('experience')->nullable(true)->default(null);
                $table->integer('picture_id')->nullable(true)->default(null);
                $table->dateTime('created')->useCurrent();
                $table->dateTime('updated')->useCurrentOnUpdate();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('plan_tasks')) {
            Schema::create('plan_tasks', function (Blueprint $table) {
                $table->id();
                $table->string('link', 255);
                $table->string('type', 255);
                $table->float('time');
                $table->integer('employe_id');
                $table->date('date');
                $table->index(['employe_id', 'date'], 'IDX_employe_id_date');
            });
        }

        if (! Schema::hasTable('statistic_tasks')) {
            Schema::create('statistic_tasks', function (Blueprint $table) {
                $table->id();
                $table->string('link', 255);
                $table->string('type', 255);
                $table->string('description', 255)->nullable(true)->default(null);
                $table->string('comment', 255)->nullable(true)->default(null);
                $table->float('lead_time');
                $table->integer('employe_id');
                $table->integer('plan_task_id')->nullable(true)->default(null);
                $table->integer('ration')->default(1);
                $table->date('date');
                $table->index(['employe_id', 'date'], 'IDX_employe_id_date');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('statistic_tasks')) {
            Schema::dropIfExists('statistic_tasks');
        }
        if (Schema::hasTable('plan_tasks')) {
            Schema::dropIfExists('plan_tasks');
        }
        if (Schema::hasTable('employes')) {
            Schema::dropIfExists('employes');
        }
    }
}
