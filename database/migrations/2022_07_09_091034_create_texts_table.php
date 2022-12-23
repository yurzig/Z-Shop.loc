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
            $table->text('content')->fulltext();
            $table->unsignedTinyInteger('type')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('editor');
        });

        Schema::create('textables', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Text::class)->index()->references('id')->on('texts')->onDelete('CASCADE');
            $table->morphs('textable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('textables');
        Schema::dropIfExists('texts');
    }
};
