<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassAssignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_assign', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->bigInteger('school_id')->default(0);
            $table->bigInteger('grade_id')->default(0);
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
        Schema::dropIfExists('class_assign');
    }
}
