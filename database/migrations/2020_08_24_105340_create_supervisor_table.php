<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupervisorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supervisor', function (Blueprint $table) {
            $table->id();
            $table->string('name',550)->nullable();
            $table->string('family',550)->nullable();
            $table->string('phone',550)->nullable();
            $table->string('password',550)->nullable();
            $table->bigInteger('school_id')->default(0);
            $table->string('email',550)->nullable();
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
        Schema::dropIfExists('supervisor');
    }
}
