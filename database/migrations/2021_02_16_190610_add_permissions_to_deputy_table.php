<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermissionsToDeputyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deputy', function (Blueprint $table) {
            $table->enum('level', ['1', '2'])->default('1')->after('email');
            $table->text('permissions')->nullable()->after('level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deputy', function (Blueprint $table) {
            //
        });
    }
}
