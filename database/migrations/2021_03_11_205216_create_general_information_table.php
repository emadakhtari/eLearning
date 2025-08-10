<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_information', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('teacher_id')->default(0);
            $table->bigInteger('school_id')->default(0);
            $table->bigInteger('grade_id')->default(0);
            $table->bigInteger('base_id')->default(0);
            $table->bigInteger('class_id')->default(0);
            $table->bigInteger('lesson_id')->default(0);
            $table->string('file_type',550)->nullable();
            $table->string('file',550)->nullable();
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
        Schema::dropIfExists('general_information');
    }
}
