<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGithubLocationUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('github_location_users', function (Blueprint $table) {
            $table->id();
            $table->string('orientation');
            $table->float('size');
            $table->string('location');
            $table->string('country');
            $table->text('lat');
            $table->text('lng');
            $table->softDeletes();
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
        Schema::dropIfExists('github_location_users');
    }
}
