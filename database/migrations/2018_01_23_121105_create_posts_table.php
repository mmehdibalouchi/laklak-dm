<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('comment_count')->nullable();
            $table->text("text");
            $table->string("type");
            $table->string("tag")->nullable();
            $table->boolean('predefined_tag')->default(false);
            $table->timestamp("last_period")->nullable();
            $table->timestamps();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
