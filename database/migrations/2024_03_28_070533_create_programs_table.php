<?php

use App\Models\City;
use App\Models\User;
use App\Models\Campus;
use App\Models\Degree;
use App\Models\Stream;
use App\Models\Country;
use App\Models\Duration;
use App\Models\Institute;
use App\Models\Intake;
use App\Models\ProgramLevel;
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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Country::class)->index()->default(1)->nullable();
            $table->foreignIdFor(City::class)->index()->nullable();
            $table->foreignIdFor(Institute::class)->index()->nullable();
            $table->foreignIdFor(Campus::class)->index()->nullable();
            $table->decimal('app_fees_cad', 10, 2)->nullable();
            $table->string('program_code')->nullable();
            $table->string('program_name')->nullable();
            $table->foreignIdFor(ProgramLevel::class)->index()->nullable();
            $table->foreignIdFor(Duration::class)->index()->nullable();
            $table->foreignIdFor(Intake::class)->index()->nullable();
            $table->boolean('conditional')->nullable();
            $table->boolean('co_op')->nullable();
            $table->string('co_op_duration')->nullable();
            $table->decimal('fees', 10, 2)->nullable();
            $table->string('ave_tat_bucket_in_days');            
            $table->foreignIdFor(Degree::class)->index()->nullable();
            $table->foreignIdFor(Stream::class)->index()->nullable();
            $table->string('cgpa_bucket')->nullable();
            $table->string('percentage_bucket')->nullable();
            $table->string('study_gap')->nullable();
            $table->string('backlogs')->nullable();
            $table->boolean('moi_accepted')->nullable();
            $table->json('exam')->nullable();
            $table->text('special_requirements')->nullable();
            $table->string('program_link')->nullable();
            $table->foreignIdFor(User::class)->index()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
