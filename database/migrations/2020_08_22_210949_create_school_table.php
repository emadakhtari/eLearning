<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school', function (Blueprint $table) {
            $table->id();
            $table->string('title',550)->nullable();
            $table->bigInteger('province')->default(0);
            $table->bigInteger('city')->default(0);
            $table->mediumText('address')->nullable();
            $table->bigInteger('postal_code')->default(0);
            $table->string('area_code',10)->nullable();
            $table->string('phone',20)->nullable();
            $table->enum('domain', ['0','1','2'])->default('0')->comment('0:Same domain-1:Subdomain of the same domain-2:Another domain');
            $table->string('domain_name',550)->nullable()->comment('if domain 0 or 1');
            $table->string('another_domain_name',550)->nullable()->comment('if domain 2');
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
        Schema::dropIfExists('school');
    }
}
