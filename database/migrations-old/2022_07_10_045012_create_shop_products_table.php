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
        Schema::create('shop_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->references('id')->on('shop_categories');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('measure')->nullable(); // код единицы измерения
            $table->foreignId('quantity')->nullable();
            $table->foreignId('reserved')->nullable();
            $table->string('dimensions')->nullable(); // габариты
            $table->unsignedInteger('weight')->nullable();
            $table->unsignedTinyInteger('status');
            $table->unsignedTinyInteger('rating')->nullable()->index();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
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
        Schema::dropIfExists('shop_products');
    }
};
