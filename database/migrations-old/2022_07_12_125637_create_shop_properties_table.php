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
        Schema::create('shop_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->index()->references('id')->on('shop_categories')->onDelete('CASCADE');
            $table->string('title');
            $table->unsignedTinyInteger('type');
            $table->boolean('filter');
            $table->json('variants');
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('editor');
        });

        Schema::create('shop_property_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->index()->references('id')->on('shop_products');
            $table->foreignId('property_id')->index()->references('id')->on('shop_properties')->onDelete('CASCADE');
            $table->decimal('value', 8, 2);
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
        Schema::dropIfExists('shop_property_values');
        Schema::dropIfExists('shop_properties');
    }
};
