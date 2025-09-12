<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGrupFildsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('group_name',550)->nullable()->after('id');
            $table->string('group_logo',550)->nullable()->after('group_name');
            $table->mediumText('group_address')->nullable()->after('group_logo');
            $table->string('group_postalCode',550)->nullable()->after('group_address');
            $table->string('group_phone',550)->nullable()->after('group_postalCode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
