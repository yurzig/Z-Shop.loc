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
        Schema::create('shop_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->references('id')->on('shop_products')->onDelete('CASCADE');
            $table->unsignedTinyInteger('type')->default(1)->index();
            $table->decimal('value', 8,2)->index();
            $table->string('title')->nullable();
            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();
            $table->boolean('status');
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
        Schema::dropIfExists('shop_prices');
    }
};
