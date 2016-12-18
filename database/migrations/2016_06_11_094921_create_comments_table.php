<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('comment_text');
            $table->integer('user_id');
            $table->string('guest_name')->default('guest');
            $table->string('type_category'); // article or acss
            $table->integer('category_item_id'); // for id article or...
            $table->boolean('publish')->default(true);
            $table->integer('like')->default(0);
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
        Schema::drop('comments');
    }
}
