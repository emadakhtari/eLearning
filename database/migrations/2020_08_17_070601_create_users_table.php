<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 45)->unique();
            $table->string('password', 450)->nullable();
            $table->string('name', 450)->nullable();
            $table->string('family', 450)->nullable();
            $table->string('publicName', 450)->nullable();
            $table->string('birthday', 450)->nullable();
            $table->string('email', 450)->unique();
            $table->mediumText('address')->nullable();
            $table->integer('level')->default(0);
            $table->bigInteger('user_category_id')->default(0);
            $table->text('permissions')->nullable();
            $table->timestamps();
            $table->enum('status', ['0','1'])->default('0');
            $table->enum('type', ['0','1'])->default('0')->comment('0:Admin,1:Assistance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
