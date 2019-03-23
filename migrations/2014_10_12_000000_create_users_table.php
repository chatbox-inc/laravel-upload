<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('team_id');
            $table->string("uid");
            $table->string('name');
            $table->string('token')->nullable();
            $table->string('email')->unique();
            $table->string('avatar');
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('t_user');
        Schema::dropIfExists('t_project');
        Schema::dropIfExists('r_project_user');
        Schema::dropIfExists('t_view');
        Schema::dropIfExists('t_view_documents');
        Schema::dropIfExists('t_view_images');
        Schema::dropIfExists('t_view_issues');
        Schema::dropIfExists('t_view_issue_label');
    }
}
