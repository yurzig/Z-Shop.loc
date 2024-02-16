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
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->references('id')->on('blog_categories')->onDelete('CASCADE');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->fulltext()->nullable();
            $table->text('content')->fulltext();
            $table->json('tags')->nullable();
            $table->boolean('status')->default(false);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->timestamp('published_at')->nullable();
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
        Schema::dropIfExists('blog_posts');
    }
};
