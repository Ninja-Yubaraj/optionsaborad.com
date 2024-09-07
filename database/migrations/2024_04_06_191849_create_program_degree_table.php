<?php

use App\Models\Degree;
use App\Models\Program;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('program_degree', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Program::class)->index()->onDelete('cascade');
            $table->foreignIdFor(Degree::class)->index()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_degree');
    }
};
