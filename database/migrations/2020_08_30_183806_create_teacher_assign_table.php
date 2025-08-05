<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherAssignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_assign', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('deputy_id')->default(0);
            $table->bigInteger('school_id')->default(0);
            $table->bigInteger('teacher_id')->default(0);
            $table->bigInteger('base_id')->default(0);
            $table->bigInteger('lesson_id')->default(0);
            $table->bigInteger('class_id')->default(0);
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
        Schema::dropIfExists('teacher_assign');
    }
}
