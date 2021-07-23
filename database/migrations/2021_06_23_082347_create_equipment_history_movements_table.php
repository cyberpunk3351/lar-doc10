<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentHistoryMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_history_movements', function (Blueprint $table) {
            $table->id();
            $table->integer('equipment_id');
            $table->datetime('datetime');
            $table->float('longitude', 8, 2);
            $table->float('latitude', 8, 2);
            $table->float('distance', 8, 2);
            $table->float('speed', 8, 2);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment_history_movements');
    }
}
