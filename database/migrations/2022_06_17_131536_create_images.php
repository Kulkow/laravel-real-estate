<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('images')) {
            Schema::create('images', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('path', 255);
                $table->string('filename', 255);
                $table->string('ext', 255);
                $table->string('mime_type', 255);
                $table->string('model', 255);
                $table->integer('filesize');
                $table->string('adapter', 255);
                $table->text('description')->nullable(true)->default(null);
                $table->dateTime('created')->useCurrent();
                $table->dateTime('updated')->useCurrentOnUpdate();
                $table->timestamps();
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
        if (Schema::hasTable('images')) {
            Schema::dropIfExists('images');
        }
    }
}
