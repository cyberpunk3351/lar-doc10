<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('idles', function (Blueprint $table) {
            $table->id();
            $table->integer('external_kod');
            $table->string('title');
            $table->string('type')->default('технический');
            $table->string('color')->default('#ff6600');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('idles');
    }
}
