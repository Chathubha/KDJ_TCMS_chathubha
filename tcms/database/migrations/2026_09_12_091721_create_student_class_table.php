<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_class', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('classroom_id')->constrained()->onDelete('cascade');
            $table->string('academic_year', 10);
            $table->timestamp('enrolled_at')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'classroom_id', 'academic_year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_class');
    }
};
