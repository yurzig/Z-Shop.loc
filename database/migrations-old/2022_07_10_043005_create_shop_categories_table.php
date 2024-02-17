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
        Schema::create('shop_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->default(0);
            $table->string('title',255);
            $table->string('slug')->unique();
            $table->string('meta_title',255)->nullable();
            $table->string('meta_description',255)->nullable();
            $table->string('tmpl_title',255)->nullable();
            $table->string('tmpl_description',255)->nullable();
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
        Schema::dropIfExists('shop_categories');
    }
};
