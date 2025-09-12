<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('school_id')->default(0);
            $table->bigInteger('deputy_id')->default(0);
            $table->bigInteger('grade_id')->default(0);
            $table->bigInteger('base_id')->default(0);
            $table->bigInteger('class_id')->default(0);
            $table->bigInteger('lesson_id')->default(0);
            $table->bigInteger('teacher_id')->default(0);
            $table->bigInteger('week_day')->default(0);
            $table->bigInteger('time_number')->default(0);
            $table->string('start_time',550)->nullable();
            $table->string('end_time',550)->nullable();
            $table->timestamps();
        });
    }

    /**
     *
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule');
    }
}
