<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accessories', function (Blueprint $table) {
            $table->increments('id');
//            $table->integer('user_id')->index();
            $table->integer('user_id');
            $table->string('video_id');
            $table->time('start_video');
            $table->string('images');
            $table->string('thumbnail');
            $table->string('advantage');
            $table->string('shortcomings');
            $table->text('text');
            $table->float('rating');
            $table->integer('accessory_id');
            $table->string('brand');
            $table->string('model');
            $table->float('price_rub');
            $table->float('price_usd');
            $table->string('store');
            $table->date('date_purchase');
            $table->boolean('review');
            $table->string('tags');
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
        Schema::drop('accessories');
    }
}
