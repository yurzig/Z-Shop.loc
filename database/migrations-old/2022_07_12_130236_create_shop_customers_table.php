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
        Schema::create('shop_customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->references('id')->on('users')->onDelete('CASCADE');
            $table->unsignedTinyInteger('type');
            $table->string('name_company');
            $table->string('patronymic');
            $table->string('surname');
            $table->string('phone');
            $table->string('email');
            $table->unsignedInteger('bonuses');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('shop_customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->index()->references('id')->on('shop_customers')->onDelete('CASCADE');
            $table->unsignedTinyInteger('type');
            $table->text('address');
            $table->json('full_address');
            $table->string('inn');
            $table->string('info');
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
        Schema::dropIfExists('shop_customer_addresses');
        Schema::dropIfExists('shop_customers');
    }
};
