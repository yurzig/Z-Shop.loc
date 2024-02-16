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
        Schema::create('shop_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->index()->references('id')->on('shop_customers')->onDelete('CASCADE');
            $table->string('order_id'); // user_id + order_number
            $table->unsignedTinyInteger('delivery_method');
            $table->decimal('delivery_cost')->nullable();
            $table->unsignedTinyInteger('payment_method');
            $table->decimal('payment_cost')->nullable();
            $table->decimal('cost');
            $table->integer('weight')->nullable();
            $table->decimal('volume')->nullable();
            $table->unsignedInteger('bonuses_added')->nullable();
            $table->unsignedInteger('bonuses_deduct')->nullable();
            $table->unsignedTinyInteger('status');
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
        Schema::dropIfExists('shop_orders');
    }
};
