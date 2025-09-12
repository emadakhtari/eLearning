<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting', function (Blueprint $table) {
            $table->id();
            $table->string('title',550)->nullable();
            $table->string('login_image',550)->nullable();
            $table->string('top_menu_image',550)->nullable();
            $table->string('signature_image',550)->nullable();
            $table->mediumText('software_text')->nullable();
            $table->mediumText('owner_text')->nullable();
            $table->mediumText('powered_text')->nullable();
            $table->mediumText('license_text')->nullable();
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
        Schema::dropIfExists('setting');
    }
}
