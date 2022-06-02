<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('topics')) {
            Schema::create('topics', function (Blueprint $table) {
                $table->id();
                $table->string('title', 255);
                $table->text('description')->nullable(true)->default(null);
                $table->integer('author_id')->nullable(true)->default(null);
                $table->integer('editor_id')->nullable(true)->default(null);
                $table->integer('publisher_id')->nullable(true)->default(null);
                $table->integer('picture_id')->nullable(true)->default(null);
                $table->dateTime('created')->useCurrent();
                $table->dateTime('updated')->useCurrentOnUpdate();
                $table->timestamps();
                $table->index(['author_id']);
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
        if (Schema::hasTable('topics')) {
            Schema::dropIfExists('topics');
        }
    }
}
