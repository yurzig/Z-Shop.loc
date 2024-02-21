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
        Schema::create('post_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->default(0);
            $table->string('title');
            $table->string('slug')->unique();
            $table->unsignedTinyInteger('sort')->default(0);
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
        Schema::dropIfExists('post_categories');
    }
};
