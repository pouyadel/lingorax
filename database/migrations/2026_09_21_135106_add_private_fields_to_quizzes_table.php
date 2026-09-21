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
        Schema::table('quizzes', function (Blueprint $table) {
            if (!Schema::hasColumn('quizzes', 'is_private')) {
                $table->boolean('is_private')->default(false)->after('is_published');
            }
            if (!Schema::hasColumn('quizzes', 'password')) {
                $table->string('password')->nullable()->after('is_private');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            if (Schema::hasColumn('quizzes', 'password')) {
                $table->dropColumn('password');
            }
            if (Schema::hasColumn('quizzes', 'is_private')) {
                $table->dropColumn('is_private');
            }
        });
    }
};