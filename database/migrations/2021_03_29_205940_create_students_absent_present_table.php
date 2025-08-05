<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsAbsentPresentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_absent_present', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('classes_completed_id')->default(0);
            $table->bigInteger('student_id')->default(0);
            $table->integer('delay')->default(0);
            $table->integer('haste')->default(0);
            $table->enum('status', ['0','1'])->default('0');
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
        Schema::dropIfExists('students_absent_present');
    }
}
