<?php

use App\Models\User;
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
        Schema::create('search_logs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('backlogs')->nullable();
            $table->string('study_gap')->nullable();
            $table->string('exam')->nullable();
            $table->string('listening')->nullable();
            $table->string('speaking')->nullable();
            $table->string('reading')->nullable();
            $table->string('writing')->nullable();
            $table->string('percentage')->nullable();
            $table->foreignIdFor(User::class, "user_id")->index();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_logs');
    }
};
