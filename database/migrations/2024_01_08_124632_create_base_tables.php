<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('adverts', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->decimal('price')->default(0);
            $table->timestamps();
        });

        Schema::create('advert_subscribers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('advert_id');
            $table->string('email');
            $table->timestamps();

            $table->unique(['advert_id', 'email']);

            $table->foreign('advert_id')->references('id')->on('adverts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adverts');
        Schema::dropIfExists('advert_subscribers');
    }
};
