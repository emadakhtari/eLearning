<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsSchoolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school', function (Blueprint $table) {
            $table->integer('this_domain')->default(0)->after('phone');
            $table->integer('subdomain_domain')->default(0)->after('this_domain');
            $table->string('subdomain_domain_name')->nullable()->after('subdomain_domain');
            $table->integer('another_domain')->default(0)->after('subdomain_domain_name');
            $table->string('another_domain_name')->nullable()->after('another_domain');
        });
    }

    /**
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
