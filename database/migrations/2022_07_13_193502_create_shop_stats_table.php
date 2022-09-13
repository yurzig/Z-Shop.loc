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
        Schema::create('shop_stats', function (Blueprint $table) {
            $table->foreignId('product_id')->index()->references('id')->on('shop_products')->onDelete('CASCADE');
            $table->foreignId('category_id')->index()->references('id')->on('shop_categories');
            $table->unsignedInteger('viewed')->index();
            $table->unsignedInteger('purchased')->index();
            $table->unsignedTinyInteger('rating')->index();
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
        Schema::dropIfExists('shop_stats');
    }
};
