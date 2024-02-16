<?php

use App\Models\Media;
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
        Schema::create('medias', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->string('object', 255)->nullable();
            $table->string('subobject', 255)->nullable();
            $table->string('link', 255);
            $table->unsignedInteger('sort')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('mediables', function (Blueprint $table) {
            $table->id();
            $table->foreignId(Media::class)->index()->references('id')->on('medias')->onDelete('CASCADE');
            $table->morphs('mediable');
            $table->unsignedTinyInteger('placement')->default(0);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mediables');
        Schema::dropIfExists('medias');
    }
};
