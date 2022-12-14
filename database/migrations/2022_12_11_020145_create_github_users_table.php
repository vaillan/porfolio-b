<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGithubUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('github_users', function (Blueprint $table) {
            $table->id();
            $table->string('avatar_url')->nullable(1);
            $table->string('bio')->nullable(1);
            $table->string('blog')->nullable(1);
            $table->string('company')->nullable(1);
            $table->date('org_created_at')->nullable(1);
            $table->string('email')->nullable(1);
            $table->string('events_url')->nullable(1);
            $table->unsignedInteger('followers')->nullable(1);
            $table->string('followers_url')->nullable(1);
            $table->unsignedInteger('following')->nullable(1);
            $table->string('following_url')->nullable(1);
            $table->string('gists_url')->nullable(1);
            $table->unsignedInteger('gravatar_id')->nullable(1);
            $table->boolean('hireable')->nullable(1);
            $table->string('html_url')->nullable(1);
            $table->unsignedInteger('org_id');
            $table->string('location');
            $table->string('login');
            $table->string('name');
            $table->string('node_id')->nullable(1);
            $table->string('organizations_url')->nullable(1);
            $table->unsignedInteger('public_gists')->nullable(1);
            $table->unsignedInteger('public_repos')->nullable(1);
            $table->string('received_events_url')->nullable(1);
            $table->string('repos_url')->nullable(1);
            $table->boolean('site_admin')->nullable(1);
            $table->string('starred_url')->nullable(1);
            $table->string('subscriptions_url')->nullable(1);
            $table->string('twitter_username')->nullable(1);
            $table->string('type')->nullable(1);
            $table->date('org_updated_at')->nullable(1);
            $table->string('url')->nullable(1);
            $table->text('latitude');
            $table->text('longitude');
            $table->string('country');
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
        Schema::dropIfExists('github_users');
    }
}
