<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlobleUsersGraphycTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('globle_users_graphyc', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order')->nullable(1);
            $table->string('startUser')->nullable(1);
            $table->string('endUser')->nullable(1);
            $table->string('type')->nullable(1);
            $table->string('startLat')->nullable(1);
            $table->string('startLng')->nullable(1);
            $table->string('endLat')->nullable(1);
            $table->string('endLng')->nullable(1);
            $table->boolean('status')->nullable(1);
            $table->date('date')->nullable(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('globle_users_graphyc');
    }
}
