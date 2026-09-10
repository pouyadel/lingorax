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
    Schema::create('quizzes', function (Blueprint $table) {
        $table->id();
        $table->string('title_fa');
        $table->string('title_en');
        $table->string('slug')->unique();
        $table->text('description_fa')->nullable();
        $table->text('description_en')->nullable();
        $table->string('level')->default('all');
        $table->string('category')->default('general');
        $table->boolean('is_published')->default(true);
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
