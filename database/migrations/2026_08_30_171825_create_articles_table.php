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
    Schema::create('articles', function (Blueprint $table) {
        $table->id();
        $table->string('title_fa');
        $table->string('title_en');
        $table->string('slug')->unique();
        $table->text('excerpt_fa')->nullable();
        $table->text('excerpt_en')->nullable();
        $table->longText('content_fa');
        $table->longText('content_en');
        $table->string('level')->default('all');
        $table->string('category')->default('general');
        $table->integer('read_time')->default(5);
        $table->string('image')->nullable();
        $table->boolean('is_published')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
