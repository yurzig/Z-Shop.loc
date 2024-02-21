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
        Schema::create('post_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->index()->references('id')->on('posts')->onDelete('CASCADE');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->unsignedTinyInteger('rating');
            $table->text('comment');
            $table->string('response', 255)->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('editor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_reviews');
    }
};
