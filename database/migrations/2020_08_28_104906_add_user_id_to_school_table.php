<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToSchoolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school', function (Blueprint $table) {
            $table->bigInteger('user_id')->default(0)->after('code');
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
