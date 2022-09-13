<?php

use App\Models\Text;
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
        Schema::create('texts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->text('content', 255);
            $table->unsignedTinyInteger('type')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('editor');
        });

        Schema::create('text_model', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Text::class)->index()->references('id')->on('texts')->onDelete('CASCADE');
            $table->morphs('text_model');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('text_model');
        Schema::dropIfExists('texts');
    }
};
