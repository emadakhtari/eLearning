<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_hours', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('school_id')->default(0);
            $table->bigInteger('deputy_id')->default(0);
            $table->enum('week_day', ['1','2','3','4','5','6','7'])->default('1');
            $table->integer('time_number')->default(0);
            $table->string('start_time',550)->nullable();
            $table->string('end_time',550)->nullable();
            $table->timestamps();
        });
    }




    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_hours');
    }
}
