<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->index()->references('id')->on('shop_products')->onDelete('CASCADE');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('name', 255);
            $table->string('email', 255);
            $table->unsignedTinyInteger('rating');
            $table->text('comment');
            $table->string('response', 255);
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->string('editor', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_reviews');
    }
};
