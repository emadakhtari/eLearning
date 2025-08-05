<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegisterTypeToSchoolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school', function (Blueprint $table) {
            $table->enum('register_type', ['1', '2', '3'])->default('1')->after('user_id')->comment('1:By the deputy - 2:By the parents - 3:By the student');
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
        Schema::table('school', function (Blueprint $table) {
            //
        });
    }
}
